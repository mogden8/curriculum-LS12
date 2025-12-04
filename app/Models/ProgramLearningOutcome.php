<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProgramLearningOutcome extends Model
{
    use HasFactory;

    protected $primaryKey = 'pl_outcome_id';

    protected $fillable = ['program_id', 'pl_outcome', 'plo_shortphrase', 'pl_outcome_id', 'plo_category_id', 'position'];

    protected static function boot()
    {
        parent::boot();

        // Add default ordering by category_id and position
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('plo_category_id', 'asc')
                ->orderBy('position', 'asc');
        });
    }

    public function learningOutcomes(): BelongsToMany
    {
        return $this->belongsToMany(LearningOutcome::class, 'outcome_maps', 'pl_outcome_id', 'l_outcome_id')->using(\App\Models\OutcomeMap::class)->withPivot('map_scale_id')->withTimestamps();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(\App\Models\PLOCategory::class, 'plo_category_id', 'plo_category_id');
    }

    // get the program that owns the program learning outcome
    // Eloquent will attempt to find a Program model with an id that matches the program_id column in the ProgramLearningOutcome model
    public function program(): BelongsTo
    {
        /*
            @param Parent model
            @param foreign key in ProgramLearningOutcome model
            @param id/PK in parent model
        */
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }
}
