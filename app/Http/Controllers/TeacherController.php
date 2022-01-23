<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(){
        return view('teacher.index');
    }
    public function create(){
        $teacher = Teacher::orderBy('id','desc')->get();
        return response()->json($teacher);
    }
    public function store(Request $request){
        $this->validate($request, [
            'name'  => 'required|max:50|min:3',
            'email'  => 'required',
            'phone'  => 'required',
        ]);
        $teacher = new Teacher();
        $teacher->name          = $request->name;
        $teacher->email         = $request->email;
        $teacher->phone         = $request->phone;
        $teacher->description   = $request->description;
        $teacher->save();

        return response()->json($teacher);
     }
     public function edit($id){
        $teacher = Teacher::findOrFail($id);
        return response()->json($teacher);
     }
     public function update(Request $request ){
        $this->validate($request , [
            'name'  => 'required|max:50|min:3',
            'email'  => 'required',
            'phone'  => 'required',
        ]);
        $teacher = Teacher::find($request->id);
         $teacher->name          = $request->name;
         $teacher->email         = $request->email;
         $teacher->phone         = $request->phone;
         $teacher->description   = $request->description;
         $teacher->save();
         return response()->json($teacher);
     }
     public function delete($id){
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return response()->json($teacher);
     }
}
