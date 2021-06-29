<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Prof;
use App\Models\User;

class ProfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('prof_modules')
        ->Join('profs','prof_modules.prof_id','=','profs.id')
        ->Join('users','profs.user_id','=','users.id')
        ->Join('modules','prof_modules.module_id','=','modules.id')
        ->select('profs.id','users.nom','users.prenom','users.email',DB::raw('GROUP_CONCAT(modules.nom) AS module'))
        ->groupBy('profs.id','users.nom','users.prenom','users.email')
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
        try {
            $user_id = UserController::store($request);
            
            DB::table('profs')->insert([
                'user_id' => $user_id
            ]); 

            $prof_id = DB::table('profs')
                ->select('id')
                ->where('user_id', '=', $user_id)
                ->get()->pull(0)->id;

            foreach ($request->module as $module) {
                $module_id = ModuleController::getId($module);
                    
                DB::table('prof_modules')->insert([
                    'prof_id' => $prof_id,
                    'module_id' => $module_id
                ]);
            }
            return true;
        }
        catch (\Throwable $th) {
            echo $th;
            return false;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::table('prof_modules')
            ->Join('profs','prof_modules.prof_id','=','profs.id')
            ->Join('users','profs.user_id','=','users.id')
            ->Join('modules','prof_modules.module_id','=','modules.id')
            ->select('profs.id','users.nom','users.prenom','users.email',DB::raw('GROUP_CONCAT(modules.nom) AS module'))
            ->groupBy('profs.id','users.nom','users.prenom','users.email')
            ->where('profs.id', '=', $id)
            ->get();
    }

    public function showM()
    {
        $id = ProfController::getProfId(auth()->user()->id); 
        return DB::table('prof_modules')
            ->Join('profs','prof_modules.prof_id','=','profs.id')
            ->Join('modules','prof_modules.module_id','=','modules.id')
            ->select('modules.id', 'modules.nom AS module')
            ->where('profs.id', '=', $id)
            ->get();
    }

    static public function userProfile($user_id)
    {
        $id = ProfController::getProfId($user_id); 
        return DB::table('prof_modules')
            ->Join('profs','prof_modules.prof_id','=','profs.id')
            ->Join('users','profs.user_id','=','users.id')
            ->Join('modules','prof_modules.module_id','=','modules.id')
            ->select('users.nom','users.prenom','users.email',DB::raw('GROUP_CONCAT(modules.nom) AS module'))
            ->groupBy('profs.id','users.nom','users.prenom','users.email')
            ->where('profs.id', '=', $id)
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
        try {
            $user = UserController::update($request, $this->getUserId($id));
            $module_id = ModuleController::getId($request->module);

            //Delete the past modules 
            DB::table('prof_modules')
            ->where('prof_id', $id)
            ->delete();

            //create a new ones
            foreach ($request->module as $module) {
                $module_id = ModuleController::getId($module);
                    
                DB::table('prof_modules')->insert([
                    'prof_id' => $id,
                    'module_id' => $module_id
                ]);
            
            }
            return true;
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::table('prof_modules')
                ->where('prof_id', $id)
                ->delete();
            $user_id = $this->getUserId($id);
            PfeController::destroyP($id);
            Prof::destroy($id);
            User::destroy($user_id);
            return true;
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }

    }

    public function getUserId ($prof_id)
    {
        return DB::table('profs')
        ->select('user_id')
        ->where('profs.id', '=', $prof_id)
        ->get()->pull(0)->user_id;
    }

    static public function getProfId ($user_id)
    {
        return DB::table('profs')
        ->select('id')
        ->where('profs.user_id', '=', $user_id)
        ->get()->pull(0)->id;
    }
}
