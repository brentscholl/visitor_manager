<?php

namespace App\Providers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Spark\Plan;
use Spark\Spark;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Spark::billable(Team::class)->resolve(function (Request $request) {
            return $request->user();
        });

        Spark::billable(Team::class)->authorize(function (Team $billable, Request $request) {
            return $request->user() &&
                   $request->user()->id == $billable->id;
        });

        Spark::billable(Team::class)->checkPlanEligibility(function (Team $billable, Plan $plan) {
            // if ($billable->projects > 5 && $plan->name == 'Basic') {
            //     throw ValidationException::withMessages([
            //         'plan' => 'You have too many projects for the selected plan.'
            //     ]);
            // }
        });
    }

    public function register(): void
    {
        Spark::ignoreMigrations();
    }
}
