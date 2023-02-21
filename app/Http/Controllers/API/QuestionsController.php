<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Questions;
use App\Models\SubSections;
use Validator;

class QuestionsController extends Controller
{
    public function index()
    {
        //return Questions::all();
        //return Questions::with('options')->get();
        return Questions::with('options')->orderBy('order')->get();
    }

    public function show(Questions $question)
    {
        return $question;
    }
    public function indexSubSection(SubSections $subsection)
    {
        return Questions::select()->where('sub_section_id', $subsection->sub_section_id)->orderBy('order')->get();
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'sub_section_id' => 'required|uuid',
            'order' => 'required|string',
            'question_id_related' => 'uuid',
            'option_id_related' => 'uuid',
            'note' => 'string',
            'required' => 'boolean'
        ]);
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $questions = Questions::create($request->all());

        return response()->json($questions, 201);
    }

    public function update(Request $request, Questions $question)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string',
            'sub_section_id' => 'sometimes|uuid',
            'order' => 'sometimes|string',
            'question_id_related' => 'sometimes|uuid',
            'option_id_related' => 'sometimes|uuid',
            'note' => 'sometimes|string',
            'required' => 'sometimes|boolean'
        ]);
        if($validator->fails()){
            return response()->json([count($validator->errors())>1?'errors':'error'=>$validator->errors()], 401);
        }

        $question->update($request->all());

        return response()->json($question, 200);
    }

    public function destroy(Questions $question)
    {
        $question->delete();

        return response()->json(null, 204);
    }
}
