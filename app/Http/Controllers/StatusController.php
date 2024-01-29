<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Status;
use Illuminate\Support\Facades\Crypt;
use DB;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $status = Status::where('status',1)->get();
        return view('pages.status.index',compact('status'));
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
      

        DB::beginTransaction();
        try{
            Status::create([
                'name' => $request->name,
            ]);
            DB::commit();
            return redirect()->back()->with('status','Status Added');

        }catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong');
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
        $id = Crypt::decrypt($id);
        $status = Status::where('id',$id)->first();
        $status->delete();
        return redirect()->back()->with('status','Deleted Successfully');
    }
}
