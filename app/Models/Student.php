<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;

class Student extends Authenticatable
{
    use Notifiable, SoftDeletes;

    public $timestamps = true;

    protected $guard = 'student'; //TODO

    protected $fillable = [
        'name',
        'surname',
        'sex',
        'birthdate',
        'description'
    ];

    protected $hidden = [
        'login',
        'password'
    ];

    public static $rules = [
        'login' => 'sometimes|unique:students|string|max:255', //TODO
        'password' => 'sometimes|required|confirmed|string|max:255',
        'name' => 'required|string|min:1|max:255',
        'surname' => 'required|string|min:1|max:255',
        'sex' => 'required|in:"male","female"',
        'birthdate' => 'required|date',
        'description' => 'nullable|string',
        'schedulededucationalactivity_id' => 'sometimes|required|integer|exists:scheduled_educational_activities,id',
    ];

    public const PASSWORD_SYMBOLS = [
        '*',
        '-',
        '+'
    ];

    public const PASSWORD_WORDS = [
        'CANAPE',
        'ORANGE',
        'BANANE'
    ];

    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($student) {
            $student->oldProfileDrawing()->delete();
            $student->keywords()->detach();

            foreach ($student->correspondents()->get() as $correspondent) {
                $correspondent->delete();
            }

            foreach ($student->messages()->get() as $message) {
                $message->delete();
            }

            foreach ($student->sent()->get() as $sent) {
                $sent->delete();
            }

            foreach ($student->drafts()->get() as $draft) {
                $draft->delete();
            }
        });
    }

    public static function getValidation(Array $inputs)
    {
        $validator = Validator::make($inputs, self::$rules);
        $validator->after(function ($validator) use ($inputs) {
            // if necessary, additional constraints
        });
        return $validator;
    }

    //TODO CHECKBOX NAMES
    public static function createOne($inputs)
    {
        $new = new self();

        $new->fill($inputs);

        $name = $inputs['name'][0];
        $surname = $inputs['surname'][0];

        if(isset($inputs['login']))
        {
            $new->login = $inputs['login'];
        }
        else
        {
            $pin = self::generatePIN();
            $new->login = $name . $surname . $pin;
        }

        if(isset($inputs['password']))
        {
            $new->password = bcrypt($inputs['password']);
        }
        else
        {
            $password = self::generatePassword();
            $new->password = bcrypt($password);
            session()->flash('password', $password);
        }

        $new->scheduledEducationalActivity()->associate(ScheduledEducationalActivity::find($inputs['scheduled_educational_activity_id']));

        $new->save();

        if(isset($inputs['keywords']))
        {
            $new->keywords()->sync($inputs['keywords'], false);
        }

        return $new;
    }

    public static function updateOne($student, $inputs)
    {
        $student->fill($inputs);

        if(!isset($inputs['loginNoUpdate']))
        {
            if(isset($inputs['loginAuto']))
            {
                $student->login = $student->generateLogin();
            }
            else
            {
                $student->login = $inputs['login'];
            }
        }

        if(!isset($inputs['passwordNoUpdate']))
        {
            if(isset($inputs['passwordAuto']))
            {
                $password = self::generatePassword();
                $student->password = bcrypt($password);

                session()->flash('password', $password);
            }
            else
            {
                $student->password = bcrypt($inputs['password']);
            }
        }

        $student->save();
        $student->keywords()->sync($inputs['keywords']);

        /*if(isset($inputs['keywords']))
        {
            $new->keywords()->sync($inputs['keywords'], false);
        }*/

        return $student;
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->diff(Carbon::now())->format('%y');
    }

    public function oldProfileDrawing()
    {
        return $this->hasOne(OldProfileDrawing::class);
    }

    public function scheduledEducationalActivity()
    {
        return $this->belongsTo(ScheduledEducationalActivity::class);
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class);
    }

    public function correspondents()
    {
        return $this->belongsToMany(Student::class, 'students_students','student_a_id','student_b_id');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'recipient')->whereIn('status', ['new', 'read']);
    }

    public function moderation_recipient()
    {
        return $this->morphMany(Message::class, 'recipient')->whereIn('status', ['moderation_recipient']);
    }

    public function sent()
    {
        return $this->morphMany(Message::class, 'sender')->where('status', '!=', 'draft');
    }

    public function drafts()
    {
        return $this->morphMany(Message::class, 'sender')->where('status', '=', 'draft');
    }

    private function generateLogin()
    {
        $n = $this->name[0];
        $s = $this->surname[0];

        $pin = self::generatePIN();

        return $n . $s . $pin;
    }

    private static function generatePassword($year = 1991)
    {
        $symbol = self::PASSWORD_SYMBOLS[array_rand(self::PASSWORD_SYMBOLS)];
        $word1 = self::PASSWORD_WORDS[array_rand(self::PASSWORD_WORDS)];
        $word2 = '';

        do
        {
            $word2 = self::PASSWORD_WORDS[array_rand(self::PASSWORD_WORDS)];
        }
        while($word2 === $word1);

        $word1 = strtolower($word1);
        $word2 = strtolower($word2);

        $wich = rand(1 , 2);

        if($wich == 1)
        {
            $word1 = ucfirst($word1);
        }
        else
        {
            $word2 = ucfirst($word2);
        }

        return $word1 . $symbol . $word2 . $symbol . $year;
    }

    // on genere un pin de 4 nombre sous forme de string, pour ne pas perdre les "chiffres"
    // commencent par 0, par exemple, 0123
    private static function generatePIN($digits = 4)
    {
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while ($i < $digits) {
            // generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }
}
