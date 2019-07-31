<?php

namespace App\Http\Controllers;

use App\Canton;
use App\ScheduledEducationalActivity;
use App\ScheduledEducationalActivityLevel;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ScheduledEducationalActivityController extends Controller
{
    public function index()
    {
        $data = [
            'scheduledEducationalActivities' => ScheduledEducationalActivity::paginate(15)
        ];

        return view('schedulededucationalactivities.index', $data);
    }

    public function show($id)
    {
        $scheduledEducationalActivity = ScheduledEducationalActivity::findorfail($id);

        $data = [
            'scheduledEducationalActivity' => $scheduledEducationalActivity,
            'students' => $scheduledEducationalActivity->students,
        ];

        return view('schedulededucationalactivities.show', $data);
    }

    public function create()
    {
        $cantons = Canton::all();
        $levels = ScheduledEducationalActivityLevel::all();
        $teachers = Teacher::all();

        $data = [
            'cantons' => $cantons->pluck('name', 'id'),
            'levels' => $levels->pluck('harmos_degree', 'id'),
            'teachers' => $teachers->pluck('name', 'id'),
        ];

        return view('schedulededucationalactivities.createOrUpdate')->with($data);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $validation = ScheduledEducationalActivity::getValidation($inputs);

        if ($validation->fails())
        {
            $data = [

            ];

            return redirect()->back()->with($data)->withErrors($validation)->withInput();
        }

        $student = ScheduledEducationalActivity::createOne($inputs);

        return redirect()->route('classes.index')->with('success', 'Item successfully edited!'); //TODO
    }

    public function edit($id)
    {
        $scheduledEducationalActivity = ScheduledEducationalActivity::findOrFail($id);

        $teacher = $scheduledEducationalActivity->teacher;

        if(Auth::guard('teacher')->check() && $teacher->isNot(Auth::user()))
        {
            abort('404');
        }

        $cantons = Canton::all();
        $levels = ScheduledEducationalActivityLevel::all();
        $teachers = Teacher::all();

        $data = [
            'scheduledEducationalActivity' => $scheduledEducationalActivity,
            'cantons' => $cantons->pluck('name', 'id'),
            'levels' => $levels->pluck('harmos_degree', 'id'),
            'teachers' => $teachers->pluck('name', 'id'),
        ];

        return View::make('schedulededucationalactivities.createOrUpdate')->with($data);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->all();

        $scheduledEducationalActivity = ScheduledEducationalActivity::findOrFail($id);

        $validation = ScheduledEducationalActivity::getValidation($inputs);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $scheduledEducationalActivity->fill($inputs);

        if(Auth::guard('admin')->check())
        {
            $scheduledEducationalActivity->teacher_id = $inputs['teacher_id'];
        }

        $scheduledEducationalActivity->save();

        return redirect()->back()->with('success', 'Item successfully edited!');
    }

    public function destroy($id)
    {
        $scheduledEducationalActivity = ScheduledEducationalActivity::findOrFail($id);

        $teacher = $scheduledEducationalActivity->teacher;

        if(Auth::guard('teacher')->check() && $teacher->isNot(Auth::user()))
        {
            return redirect()->back()->with('error', 'blabla');
        }

        $scheduledEducationalActivity->delete();

        return redirect(route('home'))->with('success', 'Item successfully deleted!'); //TODO
        //return redirect()->back()
    }

    public function activate(Request $request)
    {
        $id = $request->input('id');

        $scheduledEducationalActivity = ScheduledEducationalActivity::findOrFail($id);

        if($scheduledEducationalActivity->teacher == Auth::user())
        {
            $now = date('Y-m-d hh:mm:ss', time());
            $noon = date('Y-m-d 12:00:00', time());
            $late = date('Y-m-d 18:00:00', time());

            if($now < $noon)
            {
                $scheduledEducationalActivity->authorized_until = $noon;
            }
            else
            {
                $scheduledEducationalActivity->authorized_until = $late;
            }

            $scheduledEducationalActivity->save();
        }

        return redirect()->back()->with('success', 'Item successfully edited!'); //TODO
    }

    public function deactivate(Request $request)
    {
        $id = $request->input('id');

        $scheduledEducationalActivity = ScheduledEducationalActivity::findOrFail($id);

        if($scheduledEducationalActivity->teacher == Auth::user())
        {
            $scheduledEducationalActivity->authorized_until = null;
            $scheduledEducationalActivity->save();

            //TODO INVALIDATE SESSIONS
        }
        return redirect()->back()->with('success', 'Item successfully edited!'); //TODO
    }
}
