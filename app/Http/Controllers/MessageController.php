<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Message;
use App\Student;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

use Redirect;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function index()
    {
        $data = [
            'messages' => Auth::user()->messages()->orderBy('sent_at', 'DESC')->paginate(15)
        ];

        return view('messages.index', $data);
    }

    public function sent()
    {
        $data = [
            'messages' => Auth::user()->sent()->orderBy('sent_at', 'DESC')->paginate(15)
        ];

        return view('messages.index', $data);
    }

    public function drafts()
    {
        $data = [
            'messages' => Auth::user()->drafts()->orderBy('sent_at', 'DESC')->paginate(15)
        ];

        return view('messages.index', $data);
    }

    public function moderation()
    {
        if(!Auth::guard('teacher')->check()) // USELESS WITH ROUTER
        {
            abort(Response::HTTP_NOT_FOUND);
        }

        $sent = array();
        $received = array();

        $students_sender = Auth::user()->students()->whereHas('sent')->with(['sent' =>  function($query) {
            $query->where('status', '=', 'moderation_sender');
        }])->get();

        foreach($students_sender as $student)
        {
            foreach($student->sent as $message)
            {
                array_push($sent, $message);
            }
        }

        $students_recipient = Auth::user()->students()->whereHas('moderation_recipient')->with('moderation_recipient')->get();

        foreach($students_recipient as $student)
        {
            foreach($student->moderation_recipient as $message)
            {
                array_push($received, $message);
            }
        }

        $data = [
            'sent' => $sent,
            'received' => $received
        ];

        return view('messages.moderation', $data);
    }

    public function create(Request $request)
    {
        $data = array();

        if(Auth::guard('student')->check())
        {
            $student = Auth::user();

            $correspondents = $student->correspondents;

            $data['correspondents'] = $correspondents->pluck('name', 'id');
        }

        if(Auth::guard('teacher')->check())
        {
            $teachers = Teacher::all();
            $administrators = Administrator::all();

            $administrators_optgroup = $administrators;
            $teachers_optgroup = $teachers;

            foreach ($administrators_optgroup as $administrator)
            {
                $administrator->id = '1' . $administrator->id;
            }

            foreach ($teachers_optgroup as $teacher)
            {
                $teacher->id = '2' . $teacher->id;
            }

            $data['optgroups'] = [
                trans('inputs.admins') => $administrators_optgroup->pluck('name', 'id'),
                trans('inputs.teachers') => $teachers_optgroup->pluck('name', 'id'),
            ];
        }

        if(Auth::guard('admin')->check())
        {
            $teachers = Teacher::all();

            $data['teachers'] = $teachers->pluck('name', 'id');
        }

        return view('messages.createOrUpdate', $data);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $validation = Message::getValidation($inputs);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if(Auth::guard('student')->check())
        {
            Message::createOne($inputs, Auth::user(), $inputs['recipient'], get_class(new Student()));
        }

        if(Auth::guard('teacher')->check())
        {
            $type = '';
            $recipient = '';

            if(Arr::exists($inputs, 'recipient'))
            {
                $recipient = $inputs['recipient'];
            }
            else if(Arr::exists($inputs, 'contact'))
            {
                $recipient = $inputs['contact'][1];
            }

            if(Arr::exists($inputs, 'sender_type'))
            {
                $type = $inputs['sender_type'];
            }
            else if(Arr::exists($inputs, 'contact'))
            {
                $type_id = $inputs['contact'][0];

                switch($type_id)
                {
                    case 1:
                        $type = 'App\Administrator';
                        break;
                    case 2:
                        $type = 'App\Teacher';
                        break;
                    default:
                        abort(Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            $instance = new $type;

            Message::createOne($inputs, Auth::user(), $recipient, get_class($instance), true);
        }

        if(Auth::guard('admin')->check())
        {
            if(Arr::exists($inputs, 'recipient') && Arr::exists($inputs, 'sender_type'))
            {
                $instance = new $inputs['sender_type'];

                Message::createOne($inputs, Auth::user(), $inputs['recipient'], get_class($instance), true);
            }
            else
            {
                $teachers = $inputs['teachers'];

                foreach($teachers as $teacher)
                {
                    $contact = Teacher::find($teacher);

                    Message::createOne($inputs, Auth::user(), $contact->id, get_class($contact), true);
                }
            }
        }

        return redirect(route('messages.sent'))->with('success', 'Item created successfully!');
    }

    public function show($id)
    {
        $user = Auth::user();
        $message = Message::findorfail($id);

        if(!Auth::guard('teacher') && (!Auth::guard('student')->check() && $message->sender_id != $user->id && $message->recipient_id != $user->id))
        {
           abort(404);
        }

        //TODO
        if($message->recipient == Auth::user())
        {
            if($message->status == 'new')
            {
                $message->status = 'read';
                $message->save();
            }
        }

        $data = [
            'user' => $user,
            'message' => $message
        ];

        return view('messages.show', $data);
    }

    //TODO CHECK RIGHTS
    public function release($id)
    {
        $message = Message::findorfail($id);

        if($message->status == 'moderation_sender')
        {
            $message->status = 'moderation_recipient';
        }
        else if($message->status == 'moderation_recipient')
        {
            $message->status = 'new';
        }

        $message->save();

        return redirect(route('messages.moderation'))->with('success', 'Item moderated successfully!');
    }

    //TODO CHECK RIGHTS
    public function repel($id)
    {
        $message = Message::findorfail($id);

        if($message->status == 'moderation_sender')
        {
            $message->status = 'draft';
        }
        else if($message->status == 'moderation_recipient')
        {
            $message->deleted_for_recipient = true;
        }

        $message->save();

        return redirect(route('messages.moderation'))->with('success', 'Item moderated successfully!');
    }

    //TODO CHECK RIGHTS
    public function contact_student(Student $student)
    {
        $message = new Message();

        $message->recipient = $student;

        $data = [
            'message' =>  $message
        ];

        return view('messages.createOrUpdate', $data);
    }

    //TODO CHECK RIGHTS & NOT ALREADY CORRESPONDANTS
    public function contact_store(Request $request, Student $student)
    {
        $request->request->add(['recipient' => $student->id]);
        $request->request->add(['is_correspondence_request' => true]);

        return self::store($request);
    }

    //TODO CHECK RIGHTS
    public function answer(Message $message)
    {
        $data = [
            'oldMessage' => $message
        ];

        return view('messages.createOrUpdate', $data);
    }

    //TODO CHECK RIGHTS
    public function answer_store(Request $request, Message $message)
    {
        $request->request->add(['recipient' => $message->sender->id]);
        $request->request->add(['sender_type' => $message->sender_type]);

        // supression du lien unilatéral
        if($message->is_correspondence_request == true)
        {
            if(Arr::exists($request->all(), 'acceptAnswer'))
            {
                $message->sender->correspondents()->detach(Auth::user());
            }
        }

        return self::store($request);
    }

    // TODO CHECK RIGHTS
    public function edit(Message $message)
    {
        $data = [
          'message' => $message,
        ];

        return view('messages.createOrUpdate', $data);
    }

    //TODO CHECK RIGHTS
    public function update(Request $request, Message $message)
    {
        $inputs = $request->all();

        $validation = Message::getValidation($inputs);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if(Auth::guard('student')->check())
        {
            $message->status = 'moderation_sender';
        }
        else
        {
            $message->status = 'new';
        }

        $message->save();

        return redirect()->route('messages.sent')->with('success', trans('alerts.message-sent-successfully'));
    }

    //TODO CHECK RIGHTS
    public function destroy(Message $message)
    {
        $user = Auth::user();

        if($user->is($message->sender()))
        {
            $message->deleted_for_sender = true;

            $message->save();
        }
        else if($user->is($message->recipient()))
        {
            $message->deleted_for_recipient = true;

            $message->save();
        }
        else
        {
            $message->delete();
        }

        return redirect()->route('messages.index')->with('success', trans('alerts.message-deleted-successfully'));
    }
}
