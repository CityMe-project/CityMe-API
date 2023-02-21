<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answers;
use Validator;
use App\Models\User;
use App\Models\Surveys;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function index()
    {
        return Answers::all();
    }

    public function show(Answers $answer)
    {
        return $answer;
    }

    public function showWithSurvey()
    {
        $user = Auth::user();
        $survey = Surveys::select()->where('user_id_related', $user->id)->get();
        return Answers::select(
            "answers.answer_id", "answers.survey_id", "answers.complement", "answers.option_id", "options.question_id"
            )->where('survey_id', $survey[0]->survey_id)->join(
                'options', 'answers.option_id', '=', 'options.option_id'
                )->get()->groupBy("question_id");
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $survey = Surveys::select("survey_id")->where('user_id_related', $user->id)->get();
        $data = $request->all();
        $data['survey_id'] = $survey[0]->survey_id;
        $validator = Validator::make($data, [
            'survey_id' => 'required|uuid',
            'option_id' => 'required|uuid',
            'complement' => 'string'
        ]);
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        //$answers = Answers::create($request->all());
        $answers = Answers::create($data);

        return response()->json($answers, 201);
    }

    public function update(Request $request, Answers $answer)
    {
        $validator = Validator::make($request->all(), [
            'survey_id' => 'uuid',
            'option_id' => 'uuid',
            'complement' => 'string'
        ]);
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $answer->update($request->all());

        return response()->json($answer, 200);
    }

    public function destroy(Answers $answer)
    {
        $answer->delete();

        return response()->json(null, 204);
    }
}
