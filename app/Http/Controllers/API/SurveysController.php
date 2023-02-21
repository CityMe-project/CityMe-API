<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Surveys;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class SurveysController extends Controller
{
    public function index()
    {
        return Surveys::all();
    }

    public function show(Surveys $survey)
    {
        return $survey;
    }

    public function showwithid()
    {
        $user = Auth::user();
        return Surveys::select("survey_id", "shared_info", "modified_date" , "created_date")->where('user_id_related', $user->id)->get();
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $data['user_id_related'] = $user->id;
        $validator = Validator::make($data, [
            'user_id_related' => 'required|integer',
            'shared_info' => 'boolean'
        ]);
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        //$surveys = Surveys::create($request->all());
        $surveys = Surveys::create($data);

        return response()->json($surveys, 201);
    }

    public function update(Request $request, Surveys $survey)
    {
        $data = $request->all();
        $validator = Validator::make( $data, [
            'shared_info' => 'required|boolean'
        ]);
        $data["modified_date"] = "now()";
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $survey->update( $data);

        return response()->json($survey, 201);
    }

    public function submit(Request $request)
    {
        $user = Auth::user();
        $survey = Surveys::select("survey_id")->where('user_id_related', $user->id)->get();
        $data = $request->all();
        $validator = Validator::make($data, [
            'submited' => 'required|boolean'
        ]);
        $data["submited_date"] = "now()";
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }
        Surveys::where('survey_id',$survey[0]->survey_id)->update($data);

        return response()->json($this->show(Surveys::find($survey[0]->survey_id)), 201);
    }

    public function destroy(Surveys $survey)
    {
        $survey->delete();

        return response()->json(null, 204);
    }
}
