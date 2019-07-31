<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Canton extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $hidden = [

    ];

    public static $rules = [
        'name' => 'required|string|min:1|max:255|unique:cantons,name',
        'code' => 'required|string|min:2|max:2|unique:cantons,code,'
    ];

    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($canton)
        {
            foreach ($canton->scheduledEducationalActivities()->get() as $scheduledEducationalActivity)
            {
                $scheduledEducationalActivity->delete();
            }
        });
    }

    public function scheduledEducationalActivities()
    {
        return $this->hasMany(ScheduledEducationalActivity::class);
    }
}
