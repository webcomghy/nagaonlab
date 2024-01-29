<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\InvestigationType;
use Illuminate\Http\Request;

class InvestigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if(auth()->user()->type == 'M'){
            $data = Investigation::when($request->inv, function ($query) use ($request) {
            $query->where('investname', 'like', '%' . $request->inv . '%');
        })->paginate(25);
        // }else{
        //     $data = Investigation::where('created_by', auth()->user()->id)->get();
        // }
        $types = InvestigationType::where('status',1)->get();
        // $data = Investigation::get();
        return view('pages/investigations', compact('data','types'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'core'    => 'required',
            'investname'    => 'required',
            'code'    => 'required',
            'b2b_price'    => 'required',
            'b2c_price'    => 'required',
            // 'type'    => 'required',
            'tat'    => 'required',
        ]);

        try{

            $data          = new Investigation;
            $data->core    = $request->input('core');
            $data->investname  = $request->input('investname');
            $data->code = $request->input('code');
            $data->b2b_price    = $request->input('b2b_price');
            $data->b2c_price    = $request->input('b2c_price');
            $data->type    = $request->input('type');
            $data->tat    = $request->input('quantity');
            $data->quantity    = $request->input('tat');
            $data->created_by = auth()->user()->id;
            $data->save();
            return redirect()->back()->with('status', 'Investigations  Added Successfully');
        }catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Something went wrong'- $th->getMessage());
        }
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Investigation  $investigation
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $data = Investigation::find($id);
        return view('pages/investigations', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Investigation  $investigation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // dd($request->all());
        $request->validate([
            'core'       => 'required',
            'investname' => 'required',
            'code'       => 'required',
            'b2b_price'  => 'required',
            'b2c_price'  => 'required',
            'tat'        => 'required',
        ]);


       try {
            $data             = Investigation::find($id);
            $data->core       = $request->input('core');
            $data->investname = $request->input('investname');
            $data->code       = $request->input('code');
            $data->b2b_price      = $request->input('b2b_price');
            $data->b2c_price      = $request->input('b2c_price');
            $data->type      = $request->input('type');
            $data->tat      = $request->input('tat');
            $data->quantity    = $request->input('quantity'); 
            $data->save();

            return redirect()->back()->with('status', 'Investigations Updated Successfully');
       } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong-'.$e->getMessage());
       }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Investigation  $investigation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = Investigation::find($id);
        $data->delete();
        return redirect()->route('investigation');
        return back()->withStatus(__('Succesfully Deleted'));
    }
}
