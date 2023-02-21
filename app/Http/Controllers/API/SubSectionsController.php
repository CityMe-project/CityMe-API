<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubSections;
use Validator;

class SubSectionsController extends Controller
{
    public function index()
    {
        //return SubSections::all();
        return SubSections::with('questions')->orderBy('order')->get();
    }

    public function show(SubSections $subsection)
    {
        //return $subsection;
        return Sections::select()->with('questions')->where('sub_section_id', $subsection->sub_section_id)->orderBy('order')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'section_id' => 'required|uuid',
        ]);

        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $subsection = SubSections::create($request->all());

        return response()->json($subsection, 201);
    }

    public function update(Request $request, SubSections $subsection)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string',
            'section_id' => 'sometimes|uuid',
        ]);

        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $subsection->update($request->all());

        return response()->json($subsection, 200);
    }

    public function destroy(SubSections $subsection)
    {
        $subsection->delete();

        return response()->json(null, 204);
    }
}
