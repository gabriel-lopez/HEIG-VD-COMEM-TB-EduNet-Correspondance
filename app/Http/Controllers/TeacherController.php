<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class TeacherController extends Controller
{
    public function index()
    {
        $data = [
            'teachers' => Teacher::paginate(15),
        ];

        return View::make('teachers.index')->with($data);
    }

    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        $scheduledEducationalActivities = $teacher->scheduledEducationalActivities;

        $data =  [
            'teacher' => $teacher,
            'scheduledEducationalActivities' => $scheduledEducationalActivities
        ];

        return view('teachers.show', $data);
    }

    public function create()
    {
        return View::make('teachers.createOrUpdate');
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $validation = Teacher::getValidation($inputs);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $teacher = Teacher::createOne($inputs);

        return redirect(route('teachers.index'))->with('success', 'Teacher successfully created!');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);

        if(Auth::guard('teacher')->check() && $teacher->isNot(Auth::user()))
        {
            abort('404');
        }

        $data = [
            'teacher' => $teacher
        ];

        return View::make('teachers.createOrUpdate')->with($data);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        if(Auth::guard('teacher')->check() && $teacher->isNot(Auth::user()))
        {
            abort('404');
        }

        $inputs = $request->all();

        $validation = Teacher::getValidation($inputs);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if(Auth::guard('teacher')->check())
        {
            $hashedPassword = $teacher->password;
            $oldPassword = $inputs['oldPassword'];
            $newPassword = $inputs['password'];

            if(Hash::check($oldPassword, $hashedPassword))
            {
                if (Hash::check($newPassword, $hashedPassword))
                {
                    return redirect()->back()->with('error', 'new password can not be the old password !');
                }
            }
            else
            {
                return redirect()->back()->with('error', 'old password doesnt match !');
            }

            // avoid forced email changes
            $inputs['email'] = $teacher->email;
        }

        $teacher = Teacher::updateOne($teacher, $inputs);

        return redirect()->back()->with('success', 'Item successfully edited!');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        if(Auth::guard('teacher')->check() && $teacher->isNot(Auth::user()))
        {
            return redirect()->back()->with('error', 'blabla');
        }

        $teacher->delete();

        return redirect()->back()->with('success', 'Item successfully deleted!');
    }
}
