<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Crypt;
use DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = DB::table('notifications')->where('deleted_at', '=', NULL)->get();
        // dD($notifications);
        return view('pages.notification.index',compact('notifications'));
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
        $request->validate([
            'title' => 'required',
            'notice' => 'required',
        ]);
        \DB::beginTransaction();
        try {
            // dD($request->all());
            $record = Notification::create([
                'title' => $request->title,
                'notice' => $request->notice,
            ]);

            if($request->hasFile('file')){
                // dD('here');
               $file = $request->file('file');
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mime_type = $finfo->file($request->file('file'));
                if (substr_count($request->file('file'), '.') > 1) {
                    return redirect()->back()->with('error', 'Doube dot in filename');
                }
                if ($mime_type != "image/png" && $mime_type != "image/jpeg" && $mime_type != "application/pdf" && $mime_type != "application/doc") {
                    return redirect()->back()->with('error', 'File type not allowed');
                }
                $extension = $request->file('file')->getClientOriginalExtension();
                if ($extension != "jpg" && $extension != "jpeg" && $extension != "png" && $extension != "pdf" && $extension != "doc") {
                    return redirect()->back()->with('error', 'File type not allowed');
                }

                $fileName = time() . '.' . $request->file->getClientOriginalExtension();
                Request()->file('file')->move(public_path('uploads/notifications'), $fileName);
                $file_path = asset('uploads/notifications') . '/' . $fileName;
             
                $record->update([
                    'file' => $file_path,
                ]);

            }
            \DB::commit();
            return redirect()->back()->with('success','Notifications Added successfully');
     
        } catch (Exception $e) {
            \DB::rollback();
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
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            $record = DB::table('notifications')->where('id',$id)->update([
                'deleted_at' => now(),
            ]);
            // $record->delete();
            DB::commit();
            return redirect()->back()->with('success','Notification Deleted');
        } catch (Exception $e) {
            DB::rollback();
             return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function published($id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            $record = DB::table('notifications')->where('id',$id)->update([
                'status' =>1,
            ]);
            // $record->delete();
            DB::commit();
            return redirect()->back()->with('success','Notification Published');
        } catch (Exception $e) {
            DB::rollback();
             return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function unpublished($id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            $record = DB::table('notifications')->where('id',$id)->update([
                'status' =>0 ,
            ]);
            // $record->delete();
            DB::commit();
            return redirect()->back()->with('success','Notification Unpublished');
        } catch (Exception $e) {
            DB::rollback();
             return redirect()->back()->with('error','Something went wrong');
        }
    }
}
