<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CodeCardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $codeCards = $user->codeCards;

        return view('code-card',
            compact('codeCards')
        );
    }
}
