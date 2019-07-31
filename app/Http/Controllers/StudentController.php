<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\ScheduledEducationalActivity;
use App\Student;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    // OK
    public function index()
    {
        $data = [
            'students' => Student::paginate(15),
        ];

        return View::make('students.index')->with($data);
    }

    // MOK
    public function show($id)
    {
        $student = Student::findOrFail($id);

        // session()->flash('contact', $student);

        $data =  [
            'student' => $student
        ];

        return view('students.show', $data);
    }

    // OK
    public function correspondents($id)
    {
        $student = Student::findOrFail($id);

        if(Auth::guard('student') && $student->isNot(Auth::user()))
        {
            abort(Response::HTTP_NOT_FOUND);
        }

        $data =  [
            'correspondents' => $student->correspondents
        ];

        return view('students.correspondents', $data);
    }

    // OK
    public function create(Request $request)
    {
        $keywords = Keyword::all();

        if(Auth::guard('admin')->check())
        {
            $scheduledEducationalActivities = ScheduledEducationalActivity::all();
        }
        else
        {
            $teacher = Teacher::findOrFail(Auth::id());
            $scheduledEducationalActivities = $teacher->scheduledEducationalActivities;
        }

        $data = [
            'scheduledEducationalActivities' => $scheduledEducationalActivities->pluck('name', 'id'),
            'keywords' => $keywords->pluck('text', 'id')
        ];

        if($request->get('scheduledEducationalActivity'))
        {
            $data['scheduledEducationalActivity_id'] = $request->get('scheduledEducationalActivity');
        }

        return View::make('students.createOrUpdate')->with($data);
    }

    // OK
    public function store(Request $request)
    {
        $inputs = $request->all();

        $validation = Student::getValidation($inputs);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $student = Student::createOne($inputs);

        $password = session()->pull('password', null);

        return redirect()->back()->with('success', trans('alerts.created-successfully') . ' ' . trans('alerts.new-login') . ': ' . $student->login . ' ' . ($password != null ? trans('alerts.new-password') . ': ' .$password : ''));
    }

    // OK
    public function edit($id)
    {
        $student = Student::findOrFail($id);

        $scheduledEducationalActivity = $student->scheduledEducationalActivity;

        $teacher = $scheduledEducationalActivity->teacher;

        $keywords = Keyword::all();

        if(Auth::guard('teacher')->check() && $teacher->isNot(Auth::user()))
        {
            abort(Response::HTTP_NOT_FOUND);
        }

        if(Auth::guard('student')->check() && $student->isNot(Auth::user()))
        {
            abort(Response::HTTP_NOT_FOUND);
        }

        if(Auth::guard('admin')->check())
        {
            $scheduledEducationalActivities = ScheduledEducationalActivity::all();
        }
        else if(Auth::guard('teacher')->check())
        {
            $scheduledEducationalActivities = $teacher->scheduledEducationalActivities;
        }
        else
        {
            $scheduledEducationalActivities = collect();
        }

        $data = [
            'student' => $student,
            'scheduledEducationalActivities' => $scheduledEducationalActivities->pluck('name', 'id'),
            'keywords' => $keywords->pluck('text', 'id')
        ];

        return View::make('students.createOrUpdate')->with($data);
    }

    // NOTOK
    public function update(Request $request, $id)
    {
        $inputs = $request->all();

        $student = Student::findOrFail($id);

        if(Auth::guard('student')->check() && $student->isNot(Auth::user()))
        {
            abort(Response::HTTP_NOT_FOUND);
        }

        $validation = Student::getValidation($inputs);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $student = Student::updateOne($student, $inputs);

        $password = session()->pull('password', null);

        return redirect()->back()->with('success', trans('alerts.edited-successfully') . ' ' . ($password != null ? trans('alerts.new-password') . ': ' .$password : ''));
    }

    // OK
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        $scheduledEducationalActivity = $student->scheduledEducationalActivity;

        $teacher = $scheduledEducationalActivity->teacher;

        if(Auth::guard('teacher')->check() && $teacher->isNot(Auth::user()))
        {
            abort(Response::HTTP_NOT_FOUND);
        }

        $student->delete();

        return redirect()->back()->with('success', trans('alerts.deleted-successfully'));
    }
}
