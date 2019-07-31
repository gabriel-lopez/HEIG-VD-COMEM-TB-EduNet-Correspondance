<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Image extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'filename',
        'mime',
        'original_filename'
    ];

    protected $hidden = [
        //TODO
    ];

    public static $rules = [
        //TODO
    ];

    public static function getValidation(Array $inputs)
    {
        $validator = Validator::make($inputs, self::$rules);
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

        $new->owner()->associate(Auth::user());

        $new->save();

        return $new;
    }

    public function owner()
    {
        return $this->morphTo();
    }
}
