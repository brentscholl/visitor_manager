<?php

    namespace App\Models;

    use Glorand\Model\Settings\Traits\HasSettingsField;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    /**
     * Model representing a location in the application. Locations are the different forms used by customers to submit data.
     * A location can have settings, form components, submissions, and is associated with a user and team.
     */
    class Location extends Model
    {
        use HasFactory, HasSettingsField;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $guarded = ['id'];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            //
        ];

        /**
         * Default settings for a location.
         *
         * @var array
         */
        public $defaultSettings = [
            'enableVisitorDeviceSignIn' => true,
        ];

        // RELATIONSHIPS =========================================================================================

        /**
         * Get the user that owns the location.
         *
         * @return BelongsTo The relationship with the User model.
         */
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }

        /**
         * Get the team associated with the location.
         *
         * @return BelongsTo The relationship with the Team model.
         */
        public function team(): BelongsTo
        {
            return $this->belongsTo(Team::class);
        }

        /**
         * Get the form components associated with the location, ordered by the 'order' field.
         *
         * @return HasMany The relationship with the FormComponent model.
         */
        public function formComponents(): HasMany
        {
            return $this->hasMany(FormComponent::class)->orderBy('order', 'asc');
        }

        /**
         * Get the submissions associated with the location.
         *
         * @return HasMany The relationship with the Submission model.
         */
        public function submissions(): HasMany
        {
            return $this->hasMany(Submission::class);
        }

        // SCOPES ================================================================================================

        // API ===================================================================================================
    }
