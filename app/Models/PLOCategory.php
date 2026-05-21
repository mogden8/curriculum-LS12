<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PLOCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'plo_category_id';

    protected $fillable = ['program_id', 'plo_category', 'position'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderByRaw('CASE WHEN p_l_o_categories.position IS NULL THEN 1 ELSE 0 END')
                ->orderBy('p_l_o_categories.position', 'asc')
                ->orderBy('p_l_o_categories.plo_category_id', 'asc');
        });
    }

    public static function normalizePositionsForProgram($programId): void
    {
        $categories = static::withoutGlobalScope('order')
            ->where('program_id', $programId)
            ->orderByRaw('CASE WHEN position IS NULL THEN 1 ELSE 0 END')
            ->orderBy('position', 'asc')
            ->orderBy('plo_category_id', 'asc')
            ->get(['plo_category_id', 'position']);

        foreach ($categories as $index => $category) {
            $position = $index + 1;

            if ((int) $category->position !== $position) {
                static::withoutGlobalScope('order')
                    ->where('plo_category_id', $category->plo_category_id)
                    ->update(['position' => $position]);
            }
        }
    }

    public function plos(): HasMany
    {
        return $this->hasMany(ProgramLearningOutcome::class, 'plo_category_id', 'plo_category_id');
    }
}
