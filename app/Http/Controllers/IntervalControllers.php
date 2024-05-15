<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class IntervalControllers extends Controller
{
    //
    public function retrieveOnlineUsers(){
        
        $online = User::where('isOnline', true)->get();
        $totalOnline = $online->count();
        if(auth()->user()->role->role_id < 3){
            $totalOnline = $online->where('department_id', auth()->user()->department_id)->count();
        }
        return response()->json([
            'users' => $totalOnline
        ]);
    }
}
