<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class QuestionFollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function follow($question)
    {
        Auth::user()->followThis($question);

        return back();
    }

    public function followedAjaxAll(Request $request)
    {
        Auth::user()->followThis($request->get('question_id'));
        return response()->json([
            'boolean' => Auth::user()->followed($request->get('question_id'))
        ]);
    }
}
