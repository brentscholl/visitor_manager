<?php

    namespace App\Models;

    use Glorand\Model\Settings\Traits\HasSettingsField;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Fortify\TwoFactorAuthenticatable;
    use Laravel\Jetstream\HasProfilePhoto;
    use Laravel\Jetstream\HasTeams;
    use Laravel\Sanctum\HasApiTokens;

    /**
     * Model representing a user in the application.
     * Extends Laravel's Authenticatable base model and includes various traits for additional functionality.
     */
    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, HasProfilePhoto, HasTeams, Notifiable, TwoFactorAuthenticatable, HasSettingsField;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $guarded = [
            'id',
        ];

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var array<int, string>
         */
        protected $hidden = [
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
        ];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array<string, string>
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
            'trial_ends_at' => 'datetime',
        ];

        /**
         * The accessors to append to the model's array form.
         *
         * @var array<int, string>
         */
        protected $appends = [
            'profile_photo_url',
        ];

        /**
         * Default settings for the user.
         *
         * @var string[]
         */
        public $defaultSettings = [
            'tour_welcome' => true,
            'tour_locations' => true,
            'tour_submissions' => true,
        ];

        // RELATIONSHIPS =========================================================================================

        /**
         * Get the locations associated with the user.
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany The relationship with the Location model.
         */
        public function locations()
        {
            return $this->hasMany(Location::class);
        }

        // SCOPES ================================================================================================

        // API ===================================================================================================
    }
