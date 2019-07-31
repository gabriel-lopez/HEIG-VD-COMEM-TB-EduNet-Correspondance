<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Administrator extends Authenticatable
{
    use Notifiable, SoftDeletes;

    public $timestamps = true;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'surname',
        'email',
    ];

    protected $hidden = [
        'password',
        'email_verified_at'
    ];

    public static $rules = [
        'name' => 'required|string|min:1|max:255',
        'surname' => 'required|string|min:1|max:255',
        'email' => 'required|email',
        'password' => 'required|string|confirmed'
    ];

    public static function getValidation(Array $inputs, $admin = null)
    {
        if($admin != null)
        {
            Arr::pull(self::$rules, 'email');
            Arr::add(self::$rules, 'email', ['required', 'email', Rule::unique('users')->ignore($admin->id)]);
        }

        $validator = Validator::make($inputs, self::$rules);
        $validator->after(function ($validator) use ($inputs) {
            // if necessary, additional constraints
        });
        return $validator;
    }

    public static function updateOne($admin, $inputs)
    {
        $admin->fill($inputs);

        $admin->password = bcrypt($inputs['password']);

        $admin->save();

        return $admin;
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
