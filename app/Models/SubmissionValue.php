<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    /**
     * Model representing a single value in a submission. This is the actual data that the customer has submitted based on the form component.
     * Each value is associated with a specific submission and form component.
     */
    class SubmissionValue extends Model
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
         * Get the submission that this value belongs to.
         *
         * @return BelongsTo The relationship with the Submission model.
         */
        public function submission(): BelongsTo
        {
            return $this->belongsTo(Submission::class);
        }

        /**
         * Get the form component that this value is associated with.
         *
         * @return BelongsTo The relationship with the FormComponent model.
         */
        public function formComponent(): BelongsTo
        {
            return $this->belongsTo(FormComponent::class);
        }

        // SCOPES ================================================================================================

        // API ===================================================================================================
    }
