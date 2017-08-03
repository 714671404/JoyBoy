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
/*
 * 如果路由使用的是web里边的路由则使用该方法进行点赞功能
 *  public function followedAjaxAll(Request $request)
 *  {
 *      Auth::user()->followThis($request->get('question_id'));
 *      return response()->json([
 *      'followed' => Auth::user()->followed($request->get('question_id'))
*       ]);
 *   }
 */
}
