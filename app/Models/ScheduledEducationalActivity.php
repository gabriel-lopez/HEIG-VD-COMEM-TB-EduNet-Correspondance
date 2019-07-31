<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ScheduledEducationalActivity extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'level_id',
        'canton_id'
    ];

    protected $hidden = [

    ];

    public static $rules = [
        'name' => 'required|string',
        'teacher_id' => 'sometimes|exists:teachers,id',
        'level_id' => 'required|exists:scheduled_educational_activity_levels,id',
        'canton_id' => 'required|exists:cantons,id'
    ];

    public static $messages = [
        'name'    => '',
        'teacher_id'    => '',
        'level_id' => '',
        'canton_id' => '',
    ];

    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($scheduledEducationalActivity) {
            foreach ($scheduledEducationalActivity->students()->get() as $student) {
                $student->delete();
            }
        });
    }

    public static function getValidation(Array $inputs)
    {
        $validator = Validator::make($inputs, self::$rules, self::$messages);
        $validator->after(function ($validator) use ($inputs)
        {
            // if necessary, additional constraints
        });
        return $validator;
    }

    public static function createOne($inputs)
    {
        $new = new self();

        $new->fill($inputs);

        if(Auth::guard('teacher')->check())
        {
            $new->teacher_id = Auth::user()->id;
        }
        else
        {
            $new->teacher_id = $inputs['teacher_id'];
        }

        $new->save();

        return $new;
    }

    public function canton()
    {
        return $this->belongsTo(Canton::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function level()
    {
        return $this->belongsTo(ScheduledEducationalActivityLevel::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
