<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Geometries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\User;
use App\Models\Surveys;
use App\Models\Answers;

class GeometriesController extends Controller
{

    public function index()
    {
        return Geometries::all();
    }

    public function show(Geometries $geometry)
    {
        $user = Auth::user();
        $survey = Surveys::select("survey_id")->where('user_id_related', $user->id)->get();
        return Geometries::select(
            "geometries.geometry_id", \DB::raw("public.ST_AsGeoJSON(geometries.geom) as geom"), "geometries.answer_id",
            "geometries.tags", "answers.survey_id", "answers.option_id","options.question_id"
            )->join(
                'answers', 'answers.answer_id', '=', 'geometries.answer_id'
            )->join(
                'options', 'options.option_id', '=', 'answers.option_id'
            )->where('geometry_id', "=", $geometry->geometry_id)->get();

        //return $geometry;
    }

    public function indexWithSurvey(Geometries $geometry)
    {
        $user = Auth::user();
        $survey = Surveys::select("survey_id")->where('user_id_related', $user->id)->get();
        return Geometries::select(
            "geometries.geometry_id", \DB::raw("public.ST_AsGeoJSON(geometries.geom) as geom"), "geometries.answer_id",
            "geometries.tags", "answers.survey_id", "answers.option_id","options.question_id"
            )->join(
                'answers', 'answers.answer_id', '=', 'geometries.answer_id'
            )->join(
                'options', 'options.option_id', '=', 'answers.option_id'
            )->where('survey_id', $survey[0]->survey_id)->get()->groupBy("question_id");
    }

    public function indexOutput()
    {
        $surveys = Surveys::select("survey_id")->where('submited', true)->inRandomOrder()->limit(10)->get();
        return Geometries::select(
            "geometries.geometry_id", \DB::raw("public.ST_AsGeoJSON(geometries.geom) as geom"), "geometries.answer_id",
            "geometries.tags", "answers.survey_id", "answers.option_id","options.question_id", "questions.order as question_order"
            )->join(
                'answers', 'answers.answer_id', '=', 'geometries.answer_id'
            )->join(
                'options', 'options.option_id', '=', 'answers.option_id'
            )->join(
                'questions', 'questions.question_id', '=', 'options.question_id'
            )->whereIn('survey_id', $surveys)->get()->groupBy("survey_id");
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $survey = Surveys::select("survey_id")->where('user_id_related', $user->id)->get();
        $data = $request->all();

        $validator = Validator::make($data, [
            'geom' => 'required|string',
            'option_id' => 'required|uuid',
            'tags' => 'string'
        ]);
        $data['geom'] = \DB::raw("public.ST_GeomFromGeoJSON('".$data['geom']."'::text)");

        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $answer = Answers::select("answer_id")->where([
            ['survey_id', '=', $survey[0]->survey_id],
            ['option_id', '=', $data['option_id']],
        ])->get();
        if(count($answer) <= 0){
            $answer = Answers::create(["survey_id"=>$survey[0]->survey_id,"option_id"=>$data['option_id']]);
            $data['answer_id'] = $answer->answer_id;
        }else{
            $data['answer_id'] = $answer[0]->answer_id;
        }

        $geometry = $this->show(Geometries::create($data));
        return response()->json($geometry, 201);
    }

    public function update(Request $request, Geometries $geometry)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'geom' => 'string',
            'tags' => 'string'
        ]);
        $d = [];
        if(isset($data["geom"])){
            $d['geom'] = DB::raw("public.ST_GeomFromGeoJSON('".$data['geom']."'::text)");
        }
        if(isset($data["tags"])){$d["tags"] = $data["tags"];}

        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }
        $geometry->update($d);
        $record = $this->show($geometry);

        return response()->json($record, 200);
    }

    public function updateBatch(Request $request)
    {
        $data = $request->all();
        $errors = [];
        $geomids = [];
        foreach ($data as $r) {
            $validator = Validator::make($r, [
                'geometry_id' => 'required|uuid',
                'geom' => 'string',
                'tags' => 'string'
            ]);

            $d = [];
            if(isset($r["geom"])){
                $d['geom'] = DB::raw("public.ST_GeomFromGeoJSON('".$r['geom']."'::text)");
            }
            if(isset($r["tags"])){$d["tags"] = $r["tags"];}

            if($validator->fails()){
                array_push($errors, [count($validator->errors())>1?'errors':'error'=>$validator->errors()]);
            }else{
                $record = Geometries::where('geometry_id',$r["geometry_id"])->update($d);
                array_push($geomids, $this->show(Geometries::find($r["geometry_id"]))[0]);
            }
        }

        $geometries = ["errors"=> $errors, "records"=> $geomids];
        return response()->json($geometries, 200);
    }

    public function destroy(Geometries $geometry)
    {
        $geometry->delete();

        return response()->json(null, 204);
    }

    public function destroyBatch(Request $request)
    {
        $data = $request->all();
        $errors = [];
        $geomids = [];
        foreach ($data as $r) {
            $validator = Validator::make($r, [
                'geometry_id' => 'required|uuid'
            ]);

            if($validator->fails()){
                array_push($errors, [count($validator->errors())>1?'errors':'error'=>$validator->errors()]);
            }else{
                array_push($geomids, $this->show(Geometries::find($r["geometry_id"]))[0]);
                $record = Geometries::where('geometry_id',$r["geometry_id"])->delete();
            }
        }

        $geometries = ["errors"=> $errors, "records"=> $geomids];
        return response()->json($geometries, 200);
    }
}
