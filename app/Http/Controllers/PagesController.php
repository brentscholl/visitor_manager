<?php

    namespace App\Http\Controllers;

    use App\Models\Location;
    use Illuminate\Http\Request;

    /**
     * Controller to handle general pages within the application.
     */
    class PagesController extends Controller
    {
        /**
         * Display the dashboard view.
         *
         * @return \Illuminate\View\View The view for the dashboard page.
         */
        public function dashboard()
        {
            return view('dashboard');
        }
    }
