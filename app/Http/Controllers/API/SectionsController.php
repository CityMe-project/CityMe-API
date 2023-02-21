<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sections;
use Validator;

class SectionsController extends Controller
{
    public function index()
    {
        //return Sections::all();
        return Sections::with('subsections')->orderBy('order')->get();
    }

    public function show(Sections $section)
    {
        return Sections::select()->with('subsections')->where('section_id', $section->section_id)->orderBy('order')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $sections = Sections::create($request->all());

        return response()->json($sections, 201);
    }

    public function update(Request $request, Sections $section)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string'
        ]);
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }
        $section->update($request->all());

        return response()->json($section, 200);
    }

    public function destroy(Sections $section)
    {
        $section->delete();

        return response()->json(null, 204);
    }
}
