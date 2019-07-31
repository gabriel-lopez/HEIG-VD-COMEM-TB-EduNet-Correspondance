<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Keyword extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'text',
        'text_normalized'
    ];

    protected $hidden = [

    ];

    public static $rules = [
        'text' => 'required|string',
        'text_normalized' => 'sometimes|string|nullable'
    ];

    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($keyword)
        {
            $keyword->students()->detach();
        });
    }

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

        if($inputs['text_normalized'] == null)
        {
            $dirty = $inputs['text'];
            $clean =\Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($dirty);
            $clean = strtolower($clean);
            $clean = preg_replace('/\s/', '-', $clean);

            $new->text_normalized = $clean;
        }

        $new->creator()->associate(Auth::user());

        $new->save();

        return $new;
    }

    public function creator()
    {
        return $this->morphTo();
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
