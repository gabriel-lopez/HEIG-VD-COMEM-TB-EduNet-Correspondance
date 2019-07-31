<?php

namespace App\Http\Controllers;

use App\Canton;
use App\Keyword;
use App\ScheduledEducationalActivity;
use App\ScheduledEducationalActivityLevel;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Student::select('*');

        if($request->has('name'))
        {
            $name = $request->get('name');

            $query->where('name', 'like', '%' . $name . '%');
        }

        if($request->has('cantons'))
        {
            $cantons = $request->get('cantons');

            $query->whereHas("scheduledEducationalActivity", function($query) use ($cantons) {
                $query->whereIn("canton_id", $cantons);
            })->get();
        }

        if($request->has('levels'))
        {
            $levels = $request->get('levels');

            $query->whereHas("scheduledEducationalActivity", function($query) use ($levels) {
                $query->whereIn("level_id", $levels);
            })->get();
        }

        if($request->has('keywords'))
        {
            $keywords = $request->get('keywords');

            $query->whereHas("keywords", function($query) use ($keywords) {
                $query->whereIn("id", $keywords);
            })->get();
        }

        if($request->has('sex') && $request->get('sex')[0] != null)
        {
            $sex = $request->get('sex')[0];

            $query->where('sex', '=', $sex);
        }

        if($request->has('searching'))
        {
            $query->where('available', '=', true);
        }

        $results = $query->get();

       $data = [
           'students' => $results
       ];

        return View::make('search.standard-results')->with($data);
    }

    public function standard()
    {
        $cantons = Canton::whereHas('scheduledEducationalActivities', function ($query) {
            $query->whereHas('students');
        })->get();

        $levels = ScheduledEducationalActivityLevel::whereHas('scheduledEducationalActivities', function ($query) {
            $query->whereHas('students');
        })->get();

        $keywords = Keyword::whereHas('students')->get();

        $data = [
            'cantons' => $cantons->pluck('name', 'id'),
            'levels' => $levels->pluck('short_name', 'id'),
            'keywords' => $keywords->pluck('text', 'id'),
        ];

        return View::make('search.standard')->with($data);
    }

    public function classes()
    {
        $scheduledEducationalActivities = ScheduledEducationalActivity::whereHas('students')->get();

        $data = [
            'scheduledEducationalActivities' => $scheduledEducationalActivities
        ];

        return View::make('search.classes')->with($data);
    }

    public function keywords()
    {
        $keywords = Keyword::whereHas('students')->get();

        $data = [
            'keywords' => $keywords->pluck('text', 'id'),
        ];

        return View::make('search.keywords')->with($data);
    }
}
