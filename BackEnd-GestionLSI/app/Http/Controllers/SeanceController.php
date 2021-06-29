<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Seance;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('seances')
            ->Join('modules','seances.module_id','=','modules.id')
            ->select('seances.id', 'day_id', 'time_id', 'modules.nom as module', 'salle')
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
        return DB::table('seances')->insert([
            'day_id' => $request->day_id,
            'time_id' => $request->time_id,
            'salle' => $request->salle,
            'module_id' => $request->module_id,
        ]);
    }

    public function show($id)
    {
        return Seance::find($id);
    }

    public function showE()
    {
        $id = StudentController::getStudentId(auth()->user()->id);
        return DB::table('seances')
            ->Join('modules','seances.module_id','=','modules.id')
            ->Join('students','students.semestre_id','=','modules.semestre_id')
            ->select('seances.day_id','seances.time_id', 'modules.nom as module', 'seances.salle')
            ->where('students.id', '=', $id)
            ->get();
    }

    public function showP()
    {
        $id = ProfController::getProfId(auth()->user()->id);
        return DB::table('seances')
            ->Join('modules','seances.module_id','=','modules.id')
            ->Join('prof_modules','prof_modules.module_id','=','modules.id')
            ->select('seances.day_id','seances.time_id', 'modules.nom as module', 'seances.salle')
            ->where('prof_modules.prof_id', '=', $id)
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
        return DB::table('seances')
            ->where('id', '=', $id)
            ->update([
                'day_id' => $request->day_id,
                'time_id' => $request->time_id,
                'salle' => $request->salle,
                'module_id' => $request->module_id,
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
        return Seance::destroy($id);
    }
}
