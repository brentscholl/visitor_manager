<?php

    namespace App\Livewire\Locations;

    use App\Exports\SubmissionsExport;
    use App\Models\Location;
    use App\Traits\Tableable;
    use Livewire\Component;
    use Livewire\WithPagination;

    /**
     * Component to manage and display submissions for a specific location,
     * with options to filter, search, and export submission data.
     */
    class Submissions extends Component
    {
        use WithPagination, Tableable;

        /**
         * @var Location The current location instance.
         */
        public $location;

        /**
         * @var string User's timezone for displaying date and time correctly.
         */
        public $userTimezone;

        /**
         * @var Collection Form components related to the location.
         */
        public $formComponents;

        /**
         * @var string Start date for filtering submissions.
         */
        public $dateFrom;

        /**
         * @var string End date for filtering submissions.
         */
        public $dateTo;

        /**
         * @var string The selected form component for text search.
         */
        public $select;

        /**
         * Initialize the component with the location data and default filters.
         *
         * @param Location $location The location instance.
         */
        public function mount(Location $location)
        {
            $this->location = $location;

            // Default date range: past 7 days
            $this->dateFrom = now()->subDays(7)->format('Y-m-d');
            $this->dateTo = now()->format('Y-m-d');

            // Filter out unnecessary components (e.g., layout-only components)
            $this->formComponents = $location->formComponents->reject(function ($component) {
                return in_array($component->type, ['divider', 'header', 'message']);
            });
        }

        /**
         * Prepare the submissions query with optional pagination.
         *
         * @param bool $paginate Whether to paginate the results.
         * @return mixed Paginated or collection of submissions.
         */
        private function prepareSubmissions($paginate = true)
        {
            $query = $this->location->submissions()->with('values.formComponent');

            // Apply date filtering
            if ($this->dateFrom) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            }
            if ($this->dateTo) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            }

            // Apply text search based on selected form component
            if ($this->search && $this->select) {
                $query->whereHas('values', function ($query) {
                    $query->whereHas('formComponent', function ($query) {
                        // Search within the label of form components
                        $query->whereJsonContains('inputs->label', $this->select);
                    })
                        ->where(function($query) {
                            // Determine the appropriate field in SubmissionValue based on the form component
                            $fieldToSearch = $this->determineFieldToSearchBasedOnSelect($this->select);
                            if ($fieldToSearch) {
                                $query->where($fieldToSearch, 'like', '%' . $this->search . '%');
                            }
                        });
                });
            }

            // Sort by creation date in descending order
            $query->orderBy('created_at', 'desc');

            return $paginate ? $query->paginate($this->perPage) : $query->get();
        }

        /**
         * Determine the field in SubmissionValue based on the selected form component.
         *
         * @param string $selectString The selected form component label.
         * @return string|null The field to search, or null if none is found.
         */
        private function determineFieldToSearchBasedOnSelect($selectString)
        {
            $result = $this->formComponents->first(function ($item) use ($selectString) {
                $inputs = json_decode($item->inputs, true);
                return isset($inputs['label']) && $inputs['label'] === $selectString;
            });
            return $this->determineFieldToSearch($result);
        }

        /**
         * Map form component types to the corresponding field in SubmissionValue.
         *
         * @param $formComponent The form component instance.
         * @return string The field in SubmissionValue to search.
         */
        private function determineFieldToSearch($formComponent)
        {
            switch ($formComponent->type) {
                case 'checkboxes':
                    return 'json_value';
                case 'paragraph':
                    return 'large_value';
                case 'consent':
                    return 'boolean_value';
                default:
                    return 'value';
            }
        }

        /**
         * Prepare submission data for display.
         *
         * @param Collection $submissions The submissions collection.
         * @param bool $paginate Whether to paginate the results.
         * @return Collection Processed submission data for display.
         */
        private function prepareSubmissionsData($submissions, $paginate = false)
        {
            return $submissions->map(function ($submission) {
                $values = [];
                foreach ($this->formComponents as $component) {
                    $valueCollection = $submission->values ?? collect();
                    $submissionValue = $valueCollection->firstWhere('form_component_id', $component->id);

                    if ($submissionValue) {
                        switch ($component->type) {
                            case 'checkboxes':
                                $value = $this->prepareCheckboxValues($submissionValue, $component);
                                break;

                            case 'date':
                                $value = $submissionValue->value ? date('M d, Y', strtotime($submissionValue->value)) : null;
                                break;

                            case 'time':
                                $value = $submissionValue->value ? date('g:i A', strtotime($submissionValue->value)) : null;
                                break;

                            default:
                                $value = $submissionValue->value ?? $submissionValue->large_value;
                                if ($submissionValue->boolean_value !== null) {
                                    $value = $submissionValue->boolean_value ? 'true' : 'false';
                                }
                                break;
                        }
                        $values[$component->id] = $value;
                    } else {
                        $values[$component->id] = null;
                    }
                }

                // Append submission creation date in user's timezone
                $values['created_at'] = $submission->created_at->timezone($this->userTimezone)->format('M d, Y @ g:i A');
                return $values;
            });
        }

        /**
         * Get a shortened header label for a form component.
         *
         * @param $formComponent The form component instance.
         * @return string The header label.
         */
        private function getFormComponentHeader($formComponent)
        {
            $inputs = json_decode($formComponent->inputs, true);
            $header = $inputs['label'] ?? $inputs['message'] ?? $inputs['content'] ?? 'Undefined';

            return strlen($header) > 40 ? substr($header, 0, 40) . '...' : $header;
        }

        /**
         * Prepare checkbox values as a comma-separated string.
         *
         * @param $submissionValue The submission value instance.
         * @param $formComponent The form component instance.
         * @return string Comma-separated checkbox values.
         */
        private function prepareCheckboxValues($submissionValue, $formComponent)
        {
            $selectedOptions = [];
            $options = json_decode($formComponent->inputs, true)['options'] ?? [];
            $jsonValues = json_decode($submissionValue->json_value, true) ?? [];

            foreach ($options as $key => $option) {
                if (!empty($jsonValues[$key]) && $jsonValues[$key] === true) {
                    $selectedOptions[] = $option;
                }
            }

            return implode(', ', $selectedOptions);
        }

        /**
         * Export submissions to Excel.
         *
         * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
         */
        public function exportToExcel()
        {
            $submissions = $this->prepareSubmissions(false);
            $submissionsData = $this->prepareSubmissionsData($submissions);

            $data = $submissionsData->map(fn($submission) => array_values($submission));
            $headers = $this->formComponents->mapWithKeys(fn($component) => [$component->id => $this->getFormComponentHeader($component)]);
            $headers['created_at'] = 'Created On';

            $data->prepend($headers->values()->toArray());

            $fileName = $this->getFilename() . '.xlsx';

            return \Excel::download(new SubmissionsExport($data), $fileName);
        }

        /**
         * Export submissions to CSV.
         *
         * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
         */
        public function exportToCsv()
        {
            $submissions = $this->prepareSubmissions(false);
            $submissionsData = $this->prepareSubmissionsData($submissions);

            $data = $submissionsData->map(fn($submission) => array_values($submission));
            $headers = $this->formComponents->mapWithKeys(fn($component) => [$component->id => $this->getFormComponentHeader($component)]);
            $headers['created_at'] = 'Created On';

            $data->prepend($headers->values()->toArray());

            $fileName = $this->getFilename() . '.csv';

            return \Excel::download(new SubmissionsExport($data), $fileName, \Maatwebsite\Excel\Excel::CSV);
        }

        /**
         * Generate a filename based on the team and location name.
         *
         * @return string The generated filename.
         */
        public function getFilename()
        {
            $teamName = preg_replace('/[^A-Za-z0-9\- ]/', '', auth()->user()->currentTeam->name);
            $locationName = preg_replace('/[^A-Za-z0-9\- ]/', '', $this->location->name);

            return str_replace(' ', '-', $teamName) . '_' . str_replace(' ', '-', $locationName) . '_' . now()->format('Y-m-d');
        }

        /**
         * Set the user's timezone.
         *
         * @param string $timezone The timezone to set.
         */
        public function setTimezone($timezone)
        {
            $this->userTimezone = session(['user_timezone' => $timezone]);
        }

        /**
         * Render the view with submission data.
         *
         * @return \Illuminate\View\View
         */
        public function render()
        {
            $this->userTimezone = session('user_timezone', 'UTC');
            $submissions = $this->prepareSubmissions();
            $submissionsData = $this->prepareSubmissionsData($submissions);

            // Generate headers for form components
            $headers = $this->formComponents->mapWithKeys(fn($component) => [$component->id => $this->getFormComponentHeader($component)]);
            $headers['created_at'] = 'Created On';

            return view('livewire.locations.submissions', [
                'formComponents' => $this->formComponents,
                'submissionsData' => $submissionsData,
                'submissions' => $submissions,
                'headers' => $headers,
                'userTimezone' => $this->userTimezone,
            ]);
        }
    }
