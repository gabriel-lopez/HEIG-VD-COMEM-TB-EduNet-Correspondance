<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        // first we try to login as an admin
        $adminAttempt = Auth::guard('admin')->attempt(
            ['email' => $request->email, 'password' => $request->password], $request->has('remember')
        );

        if(!$adminAttempt)
        {
            // second we try to login as a student
            $studentAttempt = Auth::guard('student')->attempt(
                ['login' => $request->email, 'password' => $request->password], $request->has('remember')
            );

            //
            if($studentAttempt)
            {
                // login is correct, we need to check if class is activated or not
                $student = Student::where('login', '=', $request->email)->first();
                $scheduledEducationalActivity = $student->scheduledEducationalActivity;
                if($scheduledEducationalActivity->authorized_until == null || $scheduledEducationalActivity->authorized_until < now())
                {
                    // self::logout($request); // just in case

                    // return false;
                }
            }
            if(!$studentAttempt)
            {
                // last we try to login as a teacher
                return Auth::guard('teacher')->attempt(
                    ['email' => $request->email, 'password' => $request->password], $request->has('remember')
                );
            }

            return $studentAttempt;
        }

        return $adminAttempt;
    }
}
