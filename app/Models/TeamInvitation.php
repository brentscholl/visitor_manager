<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Laravel\Jetstream\Jetstream;
    use Laravel\Jetstream\TeamInvitation as JetstreamTeamInvitation;

    /**
     * Model representing a team invitation in the application.
     * Extends Jetstream's base TeamInvitation model.
     */
    class TeamInvitation extends JetstreamTeamInvitation
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'email',
            'role',
        ];

        /**
         * Get the team that this invitation is associated with.
         *
         * @return BelongsTo The relationship with the Team model.
         */
        public function team(): BelongsTo
        {
            return $this->belongsTo(Jetstream::teamModel());
        }
    }
