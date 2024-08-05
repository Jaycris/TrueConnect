<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserComposer
{
    public function compose(View $view)
    {
        $view->with('user', Auth::user());
    }
}