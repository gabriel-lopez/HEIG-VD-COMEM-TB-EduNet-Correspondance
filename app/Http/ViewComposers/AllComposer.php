<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AllComposer
{
    public function compose(View $view)
    {
        $view->with('user', Auth::user());
    }
}
