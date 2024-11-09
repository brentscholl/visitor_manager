<?php

    namespace App\Http\Controllers;

    use App\Models\Location;
    use Illuminate\Http\Request;
    use Illuminate\View\View;

    /**
     * Controller to handle location-related actions, including displaying the location,
     * showing forms, and viewing submissions.
     */
    class LocationController extends Controller
    {
        /**
         * Display the specified location.
         *
         * @param string $id The ID of the location.
         * @return View The view displaying the location details.
         */
        public function show(string $id): View
        {
            // Retrieve the location with associated user and team data.
            $location = Location::with('user', 'team')->find($id);

            // Ensure the authenticated user's current team matches the location's team.
            abort_unless(auth()->user()->currentTeam->id == $location->team_id, 403);

            return view('location', compact('location'));
        }

        /**
         * Display the form associated with the specified location.
         *
         * @param string $code The code of the location.
         * @return View The view displaying the form for the location.
         */
        public function showForm(string $code): View
        {
            // Retrieve the location with its form components and team.
            $location = Location::with('formComponents', 'team')->where('location_code', $code)->first();

            return view('form', compact('location'));
        }

        /**
         * Display the submissions associated with the specified location.
         *
         * @param string id The ID of the location.
         * @return View The view displaying submissions for the location.
         */
        public function submissions(string $id): View
        {
            // Retrieve the location with its form components, submissions, and submission values.
            $location = Location::with('formComponents', 'submissions', 'submissions.values')->find($id);

            return view('submissions', compact('location'));
        }
    }
