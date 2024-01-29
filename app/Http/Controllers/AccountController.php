<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ledger;
use Carbon;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {

        $today = Carbon\Carbon::today();
        if($request->from_date != []){
            $from = $request->from_date;
            $to = $request->to_date;
        }else{
            $from = $today->format('Y-m-d');
            $to = $today->format('Y-m-d');
        }

        if(auth()->user()->type == 'CC'){
            $trans = Ledger::where('coll_center_id',auth()->user()->id)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();
        }else{
            $trans = Ledger::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();
        }
        return view('pages.account.index',compact('trans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
