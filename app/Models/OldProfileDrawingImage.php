<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class OldProfileDrawingImage extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [

    ];

    protected $hidden = [

    ];

    public static $rules = [

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

        $new->save();

        return $new;
    }
}
