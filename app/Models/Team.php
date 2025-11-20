<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Laravel\Jetstream\Events\TeamCreated;
    use Laravel\Jetstream\Events\TeamDeleted;
    use Laravel\Jetstream\Events\TeamUpdated;
    use Laravel\Jetstream\Team as JetstreamTeam;
    //use Spark\Billable;

    /**
     * Model representing a team in the application.
     * Extends Jetstream's base Team model and adds billing functionality through Spark.
     */
    class Team extends JetstreamTeam
    {
        use HasFactory;
        // use Billable;

        /**
         * The attributes that should be cast to native types.
         *
         * @var array<string, string>
         */
        protected $casts = [
            'personal_team' => 'boolean',
            'trial_ends_at' => 'datetime',
        ];

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'name',
            'personal_team',
        ];

        /**
         * The event map for the model.
         *
         * @var array<string, class-string>
         */
        protected $dispatchesEvents = [
            'created' => TeamCreated::class,
            'updated' => TeamUpdated::class,
            'deleted' => TeamDeleted::class,
        ];

        // RELATIONSHIPS =========================================================================================

        /**
         * Get the locations associated with this team.
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany The relationship with the Location model.
         */
        public function locations()
        {
            return $this->hasMany(Location::class);
        }

        // SCOPES ================================================================================================

        // API ===================================================================================================

        /**
         * Retrieve the email associated with the team's billing (Stripe).
         *
         * @return string|null The email of the team owner.
         */
        public function stripeEmail(): string|null
        {
            return $this->owner->email;
        }
    }
