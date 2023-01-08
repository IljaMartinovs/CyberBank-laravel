<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodeCardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $codeCards = $user->codeCards;

        // Return the code cards
        return view('code-card',
            compact('codeCards')
        );
    }
}
