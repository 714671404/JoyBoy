<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/topics', function (Request $request) {
    $topics = \App\Topic::select(['id', 'name'])
        ->where('name', 'like', '%'.$request->query('q').'%' )
        ->get();
    return $topics;
});

Route::middleware('api')->post('/question/follow', function (Request $request) {
    $followed = \App\Follow::where('question_id', $request->get('question_id'))
        ->where('user_id', $request->get('user_id'))
        ->first();
    $question = \App\Question::find($request->get('question_id'));
    if($followed !== null) {
        $followed->delete();
        $question->decrement('followers_count');
        $count = $question->followers_count;
        return response()->json([
            'followed'  => false,
            'count'     => $count
        ]);
    }
    \App\Follow::create([
        'question_id'       => $request->get('question_id'),
        'user_id'       => $request->get('user_id')
    ]);

    $question->increment('followers_count');
    $count = $question->followers_count;
    return response()->json([
        'followed'  => true,
        'count'     => $count
    ]);
});