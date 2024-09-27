<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function show(string $uuid): View
    {
        $location = Location::with('user', 'team')->find($uuid);

        abort_unless(auth()->user()->currentTeam->id == $location->team_id, 403);

        return view('location', compact('location'));
    }

    public function showForm(string $uuid): View
    {
        $location = Location::with('formComponents', 'team')->find($uuid);

        return view('form', compact('location'));
    }

    public function submissions(string $uuid): View
    {
        $location = Location::with('formComponents', 'submissions', 'submissions.values')->find($uuid);

        return view('submissions', compact('location'));
    }
}
