<?php


namespace App\Repositories;

use App\Question;
use App\Topic;
use App\User;

class QuestionRepository
{
    public function byIdWithTopicAndAnswers($id)
    {
        return Question::where('id', $id)->with(['topics', 'answers'])->first();
    }

    public function byId($id)
    {
        return Question::find($id);
    }

    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    public function create(array $data)
    {
        return Question::create($data);
    }

    public function normalizeTopic(array $topic)
    {
        return collect($topic)->map(function ($topic) {
            if(is_numeric($topic)) {
                Topic::find($topic)->increment('questions_count');
                return $topic;
            }
            $topic = Topic::create([
                'name'              => $topic,
                'questions_count'   => 1
            ]);
            return (int) $topic->id;
        })->toArray();
    }
}