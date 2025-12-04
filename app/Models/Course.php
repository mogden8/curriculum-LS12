<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Backpack\CRUD\app\Models\Traits\HasIdentifiableAttribute;
    use HasFactory;

    protected $table = 'courses';

    protected $primaryKey = 'course_id';

    protected $fillable = ['course_code', 'course_num', 'course_title', 'status', 'assigned', 'type', 'year', 'semester', 'section', 'delivery_modality', 'standard_category_id', 'scale_category_id', 'AMtable', 'CLOtable', 'LAtable'];

    protected $guarded = ['course_id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_users', 'course_id', 'user_id')->withPivot('permission');
    }

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_users', 'course_id', 'user_id')->wherePivot('permission', 1);
    }

    public function editors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_users', 'course_id', 'user_id')->wherePivot('permission', 2);
    }

    public function viewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_users', 'course_id', 'user_id')->wherePivot('permission', 3);
    }

    public function learningActivities(): HasMany
    {
        return $this->hasMany(LearningActivity::class, 'course_id', 'course_id');
    }

    public function assessmentMethods(): HasMany
    {
        return $this->hasMany(AssessmentMethod::class, 'course_id', 'course_id');
    }

    public function learningOutcomes(): HasMany
    {
        return $this->hasMany(LearningOutcome::class, 'course_id', 'course_id');
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'course_programs', 'course_id', 'program_id');
    }

    public function standards(): HasMany
    {
        return $this->hasMany(Standard::class, 'standard_category_id', 'standard_category_id');
    }

    public function standardScalesCategory(): BelongsTo
    {
        return $this->belongsTo(StandardsScaleCategory::class, 'scale_category_id', 'scale_category_id');
    }

    public function standardCategory(): BelongsTo
    {
        return $this->belongsTo(StandardCategory::class, 'standard_category_id', 'standard_category_id');
    }

    public function standardOutcomes(): HasMany
    {
        return $this->hasMany(Standard::class, 'standard_category_id', 'standard_category_id');
    }

    public function courseStandardOutcomes(): HasMany
    {
        // return $this->hasMany(Standard::class, 'standard_category_id', 'standard_category_id');
        return $this->hasManyThrough(StandardScale::class, StandardsScaleCategory::class);
    }

    public function optionalPriorities(): BelongsToMany
    {
        return $this->belongsToMany(OptionalPriorities::class, 'course_optional_priorities', 'course_id', 'op_id');
    }

    // these are for the tables of child records on the course crud controller
    public function getCLOtableAttribute()
    {
        $crsID = request()->route()->parameter('id');
        $CLOs = \App\Models\LearningOutcome::where('course_id', '=', $crsID)->get();

        return json_encode($CLOs);
    }

    public function setCLOtableAttribute($value)
    {
        $crsID = request()->route()->parameter('id');
        $crsData = Course::where('course_id', '=', $crsID)->get()[0];
        $existingCLOs = \App\Models\LearningOutcome::where('course_id', '=', $crsID)->get();
        $jdata = json_decode($value);
        if (! is_array($jdata)) {
            $jdata = [];
        }
        $setCLOs = [];
        foreach ($existingCLOs as $cl) {
            array_push($setCLOs, $cl->l_outcome_id);
        }
        $nSc = [];
        foreach ($jdata as $row) {
            if (property_exists($row, 'l_outcome_id')) {
                array_push($nSc, $row->l_outcome_id);
            }
        }

        $setDel = array_filter($setCLOs, function ($element) use ($nSc) {
            return ! (in_array($element, $nSc));
        });
        foreach ($jdata as $row) {
            if (property_exists($row, 'l_outcome_id') && $row->l_outcome_id != '') {
                $id = $row->l_outcome_id;
                if (in_array($id, $setCLOs)) {
                    LearningOutcome::where('l_outcome_id', $id)->update(['clo_shortphrase' => $row->clo_shortphrase, 'l_outcome' => $row->l_outcome]);
                }
            } else {
                LearningOutcome::create(['course_id' => $crsID, 'clo_shortphrase' => $row->clo_shortphrase, 'l_outcome' => $row->l_outcome]);
            }
        }
        DB::table('learning_outcomes')->whereIn('l_outcome_id', $setDel)->delete();
        DB::table('outcome_assessments')->whereIn('l_outcome_id', $setDel)->delete();
        DB::table('outcome_activities')->whereIn('l_outcome_id', $setDel)->delete();
        DB::table('outcome_maps')->whereIn('l_outcome_id', $setDel)->delete();

    }

    public function getAMtableAttribute()
    {
        $crsID = request()->route()->parameter('id');
        $AMs = \App\Models\AssessmentMethod::where('course_id', '=', $crsID)->get();

        return json_encode($AMs);
    }

    public function setAMtableAttribute($value)
    {
        $crsID = request()->route()->parameter('id');
        $crsData = Course::where('course_id', '=', $crsID)->get()[0];
        $existingAMs = \App\Models\AssessmentMethod::where('course_id', '=', $crsID)->get();
        $jdata = json_decode($value);
        if (! is_array($jdata)) {
            $jdata = [];
        }
        $setAMs = [];
        foreach ($existingAMs as $cl) {
            array_push($setAMs, $cl->a_method_id);
        }
        $nSc = [];
        foreach ($jdata as $row) {
            if (property_exists($row, 'a_method_id')) {
                array_push($nSc, $row->a_method_id);
            }
        }

        $setDel = array_filter($setAMs, function ($element) use ($nSc) {
            return ! (in_array($element, $nSc));
        });
        foreach ($jdata as $row) {
            if (property_exists($row, 'a_method_id') && $row->a_method_id != '') {
                $id = $row->a_method_id;
                if (in_array($id, $setAMs)) {
                    AssessmentMethod::where('a_method_id', $id)->update(['weight' => $row->weight, 'a_method' => $row->a_method]);
                }
            } else {
                AssessmentMethod::create(['course_id' => $crsID, 'weight' => $row->weight, 'a_method' => $row->a_method]);
            }
        }
        DB::table('assessment_methods')->whereIn('a_method_id', $setDel)->delete();
        DB::table('outcome_assessments')->whereIn('a_method_id', $setDel)->delete();
    }

    public function getLAtableAttribute()
    {
        $crsID = request()->route()->parameter('id');
        $LAs = \App\Models\LearningActivity::where('course_id', '=', $crsID)->get();

        return json_encode($LAs);
    }

    public function setLAtableAttribute($value)
    {
        $crsID = request()->route()->parameter('id');
        $crsData = Course::where('course_id', '=', $crsID)->get()[0];
        $existingLAs = \App\Models\LearningActivity::where('course_id', '=', $crsID)->get();
        $jdata = json_decode($value);
        if (! is_array($jdata)) {
            $jdata = [];
        }
        $setLAs = [];
        foreach ($existingLAs as $cl) {
            array_push($setLAs, $cl->l_activity_id);
        }
        $nSc = [];
        foreach ($jdata as $row) {
            if (property_exists($row, 'l_activity_id')) {
                array_push($nSc, $row->l_activity_id);
            }
        }

        $setDel = array_filter($setLAs, function ($element) use ($nSc) {
            return ! (in_array($element, $nSc));
        });
        foreach ($jdata as $row) {
            if (property_exists($row, 'l_activity_id') && $row->l_activity_id != '') {
                $id = $row->l_activity_id;
                if (in_array($id, $setLAs)) {
                    LearningActivity::where('l_activity_id', $id)->update(['l_activity' => $row->l_activity]);
                }
            } else {
                LearningActivity::create(['course_id' => $crsID, 'l_activity' => $row->l_activity]);
            }
        }
        DB::table('learning_activities')->whereIn('l_activity_id', $setDel)->delete();
        DB::table('outcome_activities')->whereIn('l_activity_id', $setDel)->delete();
    }
}
