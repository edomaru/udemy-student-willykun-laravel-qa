<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use Auth;

class AnswerController extends Controller
{

    public function index(Question $question)
    {
        $answers = $question->answers()->with('user')->simplePaginate(3);
        return AnswerResource::collection($answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $answer = $question->answers()->create($request->validate([
            'body' => 'required'
        ]) + ['user_id' => Auth::id()]);

        return response()->json([
            'message' => "Your answer has been submitted successfully",
            'answer' =>  new AnswerResource($answer->load('user'))//Answer::with('user')->find($answer->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        $answer->update($request->validate([
            'body' => 'required'
        ]));

        return response()->json([
            'message' => 'Your answer has been updated successfully',
            'body_html' => $answer->body_html
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return response()->json([
            'message' => "Your answer has benn removed"
        ]);
    }
}