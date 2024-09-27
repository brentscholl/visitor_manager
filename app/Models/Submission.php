<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(SubmissionValue::class);
    }

    // SCOPES ================================================================================================

    // API ===================================================================================================
}
