<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvestigationType;
use Illuminate\Support\Facades\Crypt;

class InvestigationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('here');
        $types = InvestigationType::where('status',1)->get();
        return view('pages.investigation_types.index',compact('types'));
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
        try {
            $data = InvestigationType::create([
                'name' => $request->name,
            ]);
            return redirect()->back()->with('status','Type Added');           
        } catch (Exception $e) {
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
       
        try {
            $id = Crypt::decrypt($id);
            $data = InvestigationType::where('id',$id)->first();
            $data->delete();
            return redirect()->back()->with('status','Type Deleted Successfully');           
        } catch (Exception $e) {
            return redirect()->back()->with('error','Something went wrong');            
        }
    }
}
