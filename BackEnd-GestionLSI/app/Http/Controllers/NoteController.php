<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showP($id)
    {
        return DB::table('notes')
            ->Join('students','students.id','=','notes.student_id')
            ->Join('users','users.id','=','students.user_id')
            ->select('students.id','users.nom','users.prenom','students.cne','notes.note')
            ->where('module_id', '=', $id)
            ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showE()
    {
        $id = StudentController::getStudentId(auth()->user()->id);
        return DB::table('notes')
            ->Join('modules','modules.id','=','notes.module_id')
            ->select('modules.nom as module','notes.note')
            ->where('student_id', '=', $id)
            ->get();
    }

    static public function create($semestre_id, $student_id)
    {
        $modules = DB::table('modules')
                ->select('id')
                ->where('semestre_id', '=', $semestre_id)
                ->get();

        foreach ($modules as $key => $value) {
            DB::table('notes')->insert([
                'student_id' => $student_id,
                'module_id' => $value->id,
            ]); 
        } 
        return true;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        for ($i=0; $i < sizeof($request->student_id); $i++) { 
            DB::table('notes')
                ->where('student_id', '=', $request->student_id[$i])
                ->where('module_id', '=', $id)
                ->update([
                    'note' => $request->note[$i],
                ]); 
        }


    }

    static public function delete($id)
    {
        return DB::table('notes')
            ->where('student_id', '=', $id)
            ->delete();    
    }
}
