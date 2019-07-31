<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OldProfileDrawing extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'character_id',
        'animal_id',
        'window_id',
        'painting_id',
    ];

    protected $hidden = [

    ];

    public static $rules = [
        'character_id' => 'required|exists:old_profile_drawing_images,id', //TODO check type
        'animal_id' => 'required|exists:old_profile_drawing_images,id', //TODO check type
        'window_id' => 'required|exists:old_profile_drawing_images,id', //TODO check type
        'painting_id' => 'required|exists:old_profile_drawing_images,id', //TODO check type
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

    public static function createOne($inputs = array())
    {
        $new = new self();

        if((!in_array('character_id', $inputs))  || ($inputs['character_id'] == ('' || null)))
        {
            $inputs['character_id'] = OldProfileDrawingImage::where([ ['type', '=', 'character'], ['default', '=', true] ])->get()[0]->id;
        }

        if((!in_array('animal_id', $inputs))  || ($inputs['animal_id'] == ('' || null)))
        {
            $inputs['animal_id'] = OldProfileDrawingImage::where([ ['type', '=', 'animal'], ['default', '=', true] ])->get()[0]->id;
        }

        if((!in_array('window_id', $inputs))  || ($inputs['window_id'] == ('' || null)))
        {
            $inputs['window_id'] = OldProfileDrawingImage::where([ ['type', '=', 'window'], ['default', '=', true] ])->get()[0]->id;
        }

        if((!in_array('painting_id', $inputs))  || ($inputs['painting_id'] == ('' || null)))
        {
            $inputs['painting_id'] = OldProfileDrawingImage::where([ ['type', '=', 'painting'], ['default', '=', true] ])->get()[0]->id;
        }

        $new->fill($inputs);

        $new->save();

        return $new;
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
