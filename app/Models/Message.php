<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class Message extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'subject',
        'content'
    ];

    //TODO
    public static $rules = [
        'subject' => 'required|string|max:255',
        'content' => 'required|string',
        //'sender_id' => 'required|integer|exists:users,id',
        //'recipient_id' => 'sometimes|required|integer|exists:students,id|different:sender_id',
        //'teachers' => 'required_without_all:contact,recipient_id|array|min:0',
        //'teachers.*' => 'required|integer|exists:teachers,id',
        'status' => 'sometimes|in:"draft","new","read"',
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

    public static function createOne($inputs, $author, $id, $type, $direct = false)
    {
        $new = new self();

        $new->fill($inputs);

        $recipient = new $type;
        $recipient = $recipient->find($id);

        $new->sent_at = Carbon::now()->toDateTimeString();

        $new->sender()->associate($author);
        $new->recipient()->associate($recipient);

        if(Arr::exists($inputs, 'is_correspondence_request'))
        {
            $new->is_correspondence_request = $inputs['is_correspondence_request'];

            $author->correspondents()->attach($recipient);
        }

        if(Arr::exists($inputs, 'acceptRequest'))
        {
            $new->is_correspondence_request_answer = true;

            $author->correspondents()->attach($recipient);
        }

        if($direct)
        {
            $new->status = 'new';
        }

        $new->save();

        return $new;
    }

    public function getFormattedAnswerAttribute()
    {
        $formatted = '<p></p>';
        $formatted .= '<div style="border-left: 2px solid black; padding-left: 5px">';

        $formatted .= $this->sender->name . ' ' . $this->sender->surname;
        $formatted .= '<br>';
        $formatted .= $this->sent_at;
        $formatted .= '<br>';
        $formatted .= $this->subject;
        $formatted .= '<br>';
        $formatted .= $this->content;

        $formatted .= '</div>';

        return $formatted;
    }

    public static function saveDraft()
    {

    }

    public static function send()
    {

    }

    public function sender()
    {
        return $this->morphTo();
    }

    public function recipient()
    {
        return $this->morphTo();
    }
}
