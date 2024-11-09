<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    /**
     * Model representing a form component in the application.
     * Each component belongs to a location and can have multiple submission values associated with it.
     */
    class FormComponent extends Model
    {
        use HasFactory;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $guarded = ['id'];

        // RELATIONSHIPS =========================================================================================

        /**
         * Get the location that owns the form component.
         *
         * @return BelongsTo The relationship with the Location model.
         */
        public function location(): BelongsTo
        {
            return $this->belongsTo(Location::class);
        }

        /**
         * Get the submission values associated with this form component.
         *
         * @return HasMany The relationship with the SubmissionValue model.
         */
        public function submissionValues(): HasMany
        {
            return $this->hasMany(SubmissionValue::class);
        }

        // SCOPES ================================================================================================

        // API ===================================================================================================
    }
