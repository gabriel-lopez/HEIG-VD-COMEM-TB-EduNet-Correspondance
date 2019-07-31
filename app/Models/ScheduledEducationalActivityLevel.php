<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduledEducationalActivityLevel extends Model
{
    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($level)
        {
            foreach ($level->scheduledEducationalActivities()->get() as $level)
            {
                $level->delete();
            }
        });
    }

    public function scheduledEducationalActivities()
    {
        return $this->hasMany(ScheduledEducationalActivity::class, 'level_id');
    }
}
