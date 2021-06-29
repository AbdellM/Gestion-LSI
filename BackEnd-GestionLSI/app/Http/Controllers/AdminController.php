<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\User;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('admins')
        ->join('users', 'users.id', '=', 'admins.user_id')
        ->select('admins.id', 'users.nom', 'users.prenom', 'users.email')
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

        return DB::table('admins')->insert([
            'user_id' => $user_id,
        ]);    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::table('admins')
        ->join('users', 'users.id', '=', 'admins.user_id')
        ->select('admins.id', 'users.nom', 'users.prenom', 'users.email')
        ->where('admins.id', '=', $id)
        ->get();
    }

    static public function userProfile($user_id)
    {
        $id = AdminController::getAdminId($user_id); 
        return DB::table('admins')
        ->join('users', 'users.id', '=', 'admins.user_id')
        ->select('users.nom', 'users.prenom', 'users.email')
        ->where('admins.id', '=', $id)
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
        return $user = UserController::update($request, $this->getUserId($id));
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
        Admin::destroy($id);
        User::destroy($user_id);    
        
    }

    public function getUserId ($admin_id)
    {
        return DB::table('admins')
        ->select('user_id')
        ->where('admins.id', '=', $admin_id)
        ->get()->pull(0)->user_id;
    }

    static public function getAdminId ($user_id)
    {
        return DB::table('admins')
        ->select('id')
        ->where('admins.user_id', '=', $user_id)
        ->get()->pull(0)->id;
    }
}