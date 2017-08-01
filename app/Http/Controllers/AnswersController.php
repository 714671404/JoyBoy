<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswersRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Auth;

class AnswersController extends Controller
{
    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function store(StoreAnswersRequest $request, $question)
    {
        $answer = $this->answer->create([
            'user_id'       => Auth::id(),
            'question_id'   => $question,
            'body'          => $request->get('body')
        ]);

        $answer->question()->increment('answers_count');

        return back();
    }
}
