<?php

namespace App\Http\Controllers;

use App\Models\CollectionAgent;
use App\Models\CollectionCenter;
use App\Models\PatientDetails;
use App\Models\Referrer;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(auth()->user()->type == 'M'){
            $countcases = PatientDetails::count();
            $countcenters = CollectionCenter::count();
            $countreferrers = Referrer::count();
            $countagents = CollectionAgent::count();
        }else{
            $countcases = PatientDetails::where('created_by', auth()->user()->id)->count();
            $countcenters = CollectionCenter::where('created_by', auth()->user()->id)->count();
            $countreferrers = Referrer::where('created_by', auth()->user()->id)->count();
            $countagents = CollectionAgent::where('created_by', auth()->user()->id)->count();
        }

        // $users = User::get();
        // foreach($users as $user){
        //     $created_date = $user->created_at;
            
        // }

        $notices = DB::table('notifications')->where('status',1)->where('deleted_at',NULL)->get();
        // dD($notices);

        return view('dashboard' ,compact('countcases','countcenters','countreferrers','countagents','notices'));



    }
}
