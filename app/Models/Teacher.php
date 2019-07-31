<?php

namespace App;

use App\Rules\StrongPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;

class Teacher extends Authenticatable
{
    use Notifiable, SoftDeletes;

    public $timestamps = true;

    protected $guard = 'teacher'; //TODO

    protected $fillable = [
        'name',
        'surname',
        'email',
    ];

    protected $hidden = [
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    protected static $rules = [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        // 'email' => 'required|email|unique:teachers', //TODO
        'password' => ['required', 'confirmed'],
    ];

    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($teacher) {
            foreach ($teacher->scheduledEducationalActivities()->get() as $scheduledEducationalActivity) {
                $scheduledEducationalActivity->delete();
            }

            foreach ($teacher->messages()->get() as $message) {
                $message->delete();
            }

            foreach ($teacher->sent()->get() as $sent) {
                $sent->delete();
            }

            foreach ($teacher->drafts()->get() as $draft) {
                $draft->delete();
            }
        });
    }

    public static function getValidation(Array $inputs, $teacher = null)
    {
        if($teacher != null)
        {
            Arr::add(self::$rules, 'email', ['required', 'email', Rule::unique('users')->ignore($teacher->id)]);
        }

        $validator = Validator::make($inputs, self::$rules);
        $validator->after(function ($validator) use ($inputs) {
            // if necessary, additional constraints
        });
        return $validator;
    }

    public static function createOne($inputs)
    {
        $new = new self();

        $new->fill($inputs);

        $new->password = bcrypt($inputs['password']);

        $new->save();

        return $new;
    }

    public static function updateOne($teacher, $inputs)
    {
        $teacher->fill($inputs);

        $teacher->password = bcrypt($inputs['password']);

        $teacher->save();

        return $teacher;
    }

    public function scheduledEducationalActivities()
    {
        return $this->hasMany(ScheduledEducationalActivity::class);
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, ScheduledEducationalActivity::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'recipient');
    }

    public function sent()
    {
        return $this->morphMany(Message::class, 'sender')->where('status', '!=', 'draft');
    }

    public function drafts()
    {
        return $this->morphMany(Message::class, 'sender')->where('status', '=', 'draft');
    }
}
