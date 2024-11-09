<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    /**
     * Model representing a submission in the application. Submissions are created by the customer filling out the form.
     * Each submission is associated with a location and contains multiple submission values.
     */
    class Submission extends Model
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
         * Get the location that this submission is associated with.
         *
         * @return BelongsTo The relationship with the Location model.
         */
        public function location(): BelongsTo
        {
            return $this->belongsTo(Location::class);
        }

        /**
         * Get the values associated with this submission.
         *
         * @return HasMany The relationship with the SubmissionValue model.
         */
        public function values(): HasMany
        {
            return $this->hasMany(SubmissionValue::class);
        }

        // SCOPES ================================================================================================

        // API ===================================================================================================
    }
