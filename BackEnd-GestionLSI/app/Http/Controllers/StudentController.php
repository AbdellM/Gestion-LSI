<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\User;
use App\Models\Note;


class StudentController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('semestres', 'semestres.id', '=', 'students.semestre_id')
            ->select('students.id', 'users.nom', 'users.prenom', 'users.email', 'users.dateN','students.cne', 'semestres.nom as semestre')
            ->get();
    }
    /**
     * Display a listing of the resource by semester.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getStudentsBySemester(Request $request)
    {
        return DB::table('students')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('semestres', 'semestres.id', '=', 'students.semestre_id')
            ->select('students.id', 'users.nom', 'users.prenom')
            ->where('semestres.nom','=', $request->semestre)
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = UserController::store($request);
        $semestre_id = SemestreController::getId($request->semestre);
        DB::table('students')->insert([
                'cne' => $request->cne,
                'user_id' => $user_id,
                'semestre_id' => $semestre_id,
            ]);
        return NoteController::create($semestre_id, StudentController::getStudentId($user_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::table('students')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->join('semestres', 'semestres.id', '=', 'students.semestre_id')
                ->select('students.id', 'users.nom', 'users.prenom', 'users.email', 'users.dateN','students.cne', 'semestres.nom as semestre')
                ->where('students.id', '=', $id)
                ->get();
    }

    static public function userProfile($user_id)
    {
        $id = StudentController::getStudentId($user_id); 
        return DB::table('students')
                ->join('users', 'users.id', '=', 'students.user_id')
                ->join('semestres', 'semestres.id', '=', 'students.semestre_id')
                ->select('users.nom', 'users.prenom', 'users.email', 'users.dateN','students.cne', 'semestres.nom as semestre')
                ->where('students.id', '=', $id)
                ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = UserController::update($request, $this->getUserId($id));
        DB::table('students')
            ->where('id', $id)
            ->update([
                'cne' => $request->cne,
                'semestre_id' => $request->semestre_id,
        ]);
        NoteController::delete($id);
        return NoteController::create($request->semestre_id, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = $this->getUserId($id);
        Note::destroy($id);
        PfeController::destroyS($id);
        Student::destroy($id);
        User::destroy($user_id);
    }

    public function getUserId ($student_id)
    {
        return DB::table('students')
        ->select('user_id')
        ->where('students.id', '=', $student_id)
        ->get()->pull(0)->user_id;
    }

    static public function getStudentId ($user_id)
    {
        return DB::table('students')
        ->select('id')
        ->where('students.user_id', '=', $user_id)
        ->get()->pull(0)->id;
    }
}
