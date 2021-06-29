<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pfe;

class PfeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('pves')
        ->Join('profs','profs.id','=','pves.prof_id')
        ->Join('students','students.id','=','pves.student_id')
        ->Join('semestres','semestres.id','=','students.semestre_id')
        ->Join('users as u1','u1.id','=','profs.user_id')
        ->Join('users as u2','u2.id','=','students.user_id')
        ->select('pves.id','u2.nom as stdNom','u2.prenom as stdPrenom','students.cne','u1.nom as prfNom','u1.prenom as prfPrenom','pves.sujet','pves.dateP')
        ->get();
    }
     
    public function show($id)
    {
        return DB::table('pves')
        ->Join('profs','profs.id','=','pves.prof_id')
        ->Join('students','students.id','=','pves.student_id')
        ->Join('semestres','semestres.id','=','students.semestre_id')
        ->Join('users as u1','u1.id','=','profs.user_id')
        ->Join('users as u2','u2.id','=','students.user_id')
        ->select('pves.id','u2.nom as stdNom','u2.prenom as stdPrenom','students.cne','u1.nom as prfNom','u1.prenom as prfPrenom','pves.sujet','pves.dateP')
        ->where('pves.id', '=', $id)
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
        DB::table('pves')->insert([
            'student_id' => $request->student_id,
            'prof_id' => $request->prof_id,
            'sujet' => $request->sujet,
            'dateP' => $request->dateP,
        ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showE()
    {
        return DB::table('pves')
            ->Join('profs','profs.id','=','pves.prof_id')
            ->Join('students','students.id','=','pves.prof_id')
            ->Join('semestres','semestres.id','=','students.semestre_id')
            ->Join('users as u1','u1.id','=','profs.user_id')
            ->Join('users as u2','u2.id','=','students.user_id')
            ->select('u2.nom as stdNom','u2.prenom as stdPrenom','semestres.nom as semestre','pves.sujet','pves.dateP','u1.nom as prfNom','u1.prenom as prfPrenom')
            ->where('students.user_id', '=', auth()->user()->id)
            ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showP()
    {
        return DB::table('pves')
        ->Join('profs','profs.id','=','pves.prof_id')
        ->Join('students','students.id','=','pves.prof_id')
        ->Join('semestres','semestres.id','=','students.semestre_id')
        ->Join('users as u1','u1.id','=','profs.user_id')
        ->Join('users as u2','u2.id','=','students.user_id')
        ->select('u2.nom as stdNom','u2.prenom as stdPrenom','semestres.nom as semestre','pves.sujet','pves.dateP','u1.nom as prfNom','u1.prenom as prfPrenom')
        ->where('profs.user_id', '=', auth()->user()->id)
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
        return DB::table('pves')
            ->where('pves.id', '=', $id)
            ->update([
                'prof_id' => $request->prof_id,
                'sujet' => $request->sujet,
                'dateP' => $request->dateP,
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Pfe::destroy($id);
    }

    public static function destroyS($id)
    {
        return DB::table('pves')
            ->where('student_id', '=', $id)
            ->delete();
    }

    public static function destroyP($id)
    {
        return DB::table('pves')
            ->where('prof_id', '=', $id)
            ->delete();
    }
}
