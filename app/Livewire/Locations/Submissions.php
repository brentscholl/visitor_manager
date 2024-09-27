<?php

namespace App\Livewire\Locations;

use App\Exports\SubmissionsExport;
use App\Models\Location;
use App\Traits\Tableable;
use Livewire\Component;
use Livewire\WithPagination;


class Submissions extends Component
{
    use WithPagination;
    use Tableable;

    public $location;
    public $userTimezone;
    public $formComponents;
    public $dateFrom;
    public $dateTo;
    public $select;

    public function mount(Location $location)
    {
        $this->location = $location;

        $this->dateFrom = now()->subDays(7)->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');

        // Fetch form components related to the location
        $this->formComponents = $location->formComponents->reject(function ($component) {
            return in_array($component->type, ['divider', 'header', 'message']);
        });

        // Prepare submissions data
    }

    private function prepareSubmissions($paginate = true)
    {
        $query = $this->location->submissions()->with('values.formComponent');

        // Date filtering
        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        // Text search filtering
        if ($this->search && $this->select) {
            $query->whereHas('values', function ($query) {
                $query->whereHas('formComponent', function ($query) {
                    // Searching within the JSON column 'inputs' for a match with $this->select
                    $query->whereJsonContains('inputs->label', $this->select);
                })
                    ->where(function($query) {
                        // Additional logic to search within the appropriate field of SubmissionValue
                        $fieldToSearch = $this->determineFieldToSearchBasedOnSelect($this->select);
                        if ($fieldToSearch) {
                            $query->where($fieldToSearch, 'like', '%' . $this->search . '%');
                        }
                    });
            });
        }

        $query->orderBy('created_at', 'desc');

        return $paginate ? $query->paginate($this->perPage) : $query->get();
    }

    private function determineFieldToSearchBasedOnSelect($selectString) {
        // Implement logic to determine which field in SubmissionValue to search
        // This logic depends on how $selectString relates to the form component types
        // For example:
        $result = $this->formComponents->first(function ($item) use ($selectString) {
            $inputs = json_decode($item->inputs, true);

            if (is_array($inputs) && isset($inputs['label']) && $inputs['label'] === $selectString) {
                return true;
            }

            return false;
        });
        return $this->determineFieldToSearch($result);
    }

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
                            $value = $submissionValue->value ?
                                date('M d, Y', strtotime($submissionValue->value)) : null;
                            break;

                        case 'time':
                            $value = $submissionValue->value ?
                                date('g:i A', strtotime($submissionValue->value)) : null;
                            break;

                        default:
                            $value = $submissionValue->value
                                ?? $submissionValue->large_value;
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

            $values['created_at'] = $submission->created_at->timezone($this->userTimezone)->format('M d, Y @ g:i A');
            return $values;
        });
    }

    private function determineFieldToSearch($formComponent) {
        switch ($formComponent->type) {
            case 'checkboxes':
                // For checkboxes, the data is stored in 'json_value'
                return 'json_value';

            case 'paragraph':
                // For text components, the data is stored in 'large_value'
                return 'large_value';

            case 'consent':
                // For consent components, the data is stored in 'boolean_value'
                return 'boolean_value';

            // Add additional cases for other types of form components if necessary

            default:
                // Default case if the form component type doesn't match any of the above
                return 'value';
        }
    }

    private function getFormComponentHeader($formComponent)
    {
        $inputs = json_decode($formComponent->inputs, true);
        $header = $inputs['label'] ?? $inputs['message'] ?? $inputs['content'] ?? 'Undefined';

        if (strlen($header) > 40) {
            return substr($header, 0, 40) . '...';
        }

        return $header;
    }

    private function prepareCheckboxValues($submissionValue, $formComponent) {
        $selectedOptions = [];
        $options = json_decode($formComponent->inputs, true)['options'] ?? [];
        $jsonValues = json_decode($submissionValue->json_value, true) ?? [];

        foreach ($options as $key => $option) {
            if (!empty($jsonValues[$key]) && $jsonValues[$key] === true) {
                $selectedOptions[] = $option;
            }
        }

        return implode(', ', $selectedOptions); // Convert array to comma-separated string
    }

    public function exportToExcel()
    {
        $submissions = $this->prepareSubmissions(false);
        $submissionsData = $this->prepareSubmissionsData($submissions);

        $data = $submissionsData->map(function ($submission) {
            return array_values($submission);
        });

        $headers = $this->formComponents->mapWithKeys(function ($component) {
            return [$component->id => $this->getFormComponentHeader($component)];
        });

        $headers['created_at'] = 'Created On';

        $data->prepend($headers->values()->toArray());

        $fileName = $this->getFilename() . '.xlsx';

        return \Excel::download(new SubmissionsExport($data), $fileName);
    }

    public function exportToCsv()
    {
        $submissions = $this->prepareSubmissions(false);
        $submissionsData = $this->prepareSubmissionsData($submissions);

        $data = $submissionsData->map(function ($submission) {
            return array_values($submission);
        });

        $headers = $this->formComponents->mapWithKeys(function ($component) {
            return [$component->id => $this->getFormComponentHeader($component)];
        });

        $headers['created_at'] = 'Created On';

        $data->prepend($headers->values()->toArray());

        $fileName = $this->getFilename() . '.csv';

        return \Excel::download(new SubmissionsExport($data), $fileName, \Maatwebsite\Excel\Excel::CSV);
    }

    public function getFilename() {
        $teamName = preg_replace('/[^A-Za-z0-9\- ]/', '', auth()->user()->currentTeam->name); // Remove symbols
        $locationName = preg_replace('/[^A-Za-z0-9\- ]/', '', $this->location->name); // Remove symbols

        return str_replace(' ', '-', $teamName) . '_' . str_replace(' ', '-', $locationName) . '_' . now()->format('Y-m-d');
    }

    public function setTimezone($timezone)
    {
        $this->userTimezone = session(['user_timezone' => $timezone]);
    }

    public function render()
    {
        $this->userTimezone = session('user_timezone', 'UTC');
        $submissions = $this->prepareSubmissions();
        $submissionsData = $this->prepareSubmissionsData($submissions);

        // Generate headers for form components
        $headers = $this->formComponents->mapWithKeys(function ($component) {
            return [$component->id => $this->getFormComponentHeader($component)];
        });

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
