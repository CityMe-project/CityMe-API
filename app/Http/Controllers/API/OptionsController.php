<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Options;
use Validator;

class OptionsController extends Controller
{
    public function index()
    {
        //return Options::all();
        return Options::orderBy('order')->get();
    }

    public function show(Options $option)
    {
        return $option;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required|uuid',
            'text' => 'required|string',
            'type' => 'required|string',
            'order' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $options = Options::create($request->all());

        return response()->json($options, 201);
    }

    public function update(Request $request, Options $option)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'sometimes|uuid',
            'text' => 'sometimes|string',
            'type' => 'sometimes|string',
            'order' => 'sometimes|string'
        ]);
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $option->update($request->all());

        return response()->json($option, 200);
    }

    public function destroy(Options $option)
    {
        $option->delete();

        return response()->json(null, 204);
    }
}
