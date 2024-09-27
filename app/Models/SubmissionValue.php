<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function formComponent(): BelongsTo
    {
        return $this->belongsTo(FormComponent::class);
    }
    // SCOPES ================================================================================================

    // API ===================================================================================================
}
