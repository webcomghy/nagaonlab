<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use DB;
use Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    // public function index(User $model)
    // {
    //     return view('users.index', ['users' => $model->paginate(15)]);

    //     // $data = User::get();
    //     // return view('profile.edit', compact('data'));

    // }

    public function addUser(){
        $users = User::where('type','!=','M')->get();
        return view('pages.user.add-new-user',compact('users'));
    }

    public function storeUser(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'password' => 'required', 'string', 'min:8', 'confirmed',
        ]);

        DB::beginTransaction();
        try {
            $count = User::where('type','!=','M')->max('id');
            $user = str_pad($count, 6, '0', STR_PAD_LEFT);
            $name = strtoupper(substr($request->name, 0, 3));
            $username = 'HCL'.$name.$user;
            // dD($username);
            $user = User::create([
                'name' => $request->name,
                'username' => $username ,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'phone' => $request->mobile,
                'lab_email' => $request->email,
                'type' => 'CC',
                'edit_permission' => '0',
                'delete_permission' => '0',
                'update_status' => '0',
                'coll_center' => '1',
                'coll_agents' => '1',
                'investigations' => '1',
                'referrer' => '1',
            ]);

            $user->update([
                    'subscription_date' => $user->created_at,
            ]);
            // dD($user);
            DB::commit();
         return redirect()->back()->with('status','New User Added');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong');
        }
    }


    public function activateUser($id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            $user = User::where('id',$id)->first();
            $user->update([
                'status' => 1,
            ]);

            DB::commit();
          return redirect()->back()->with('status','User Activated');  
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong');
        }

    }

    public function deactivateUser($id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            $user = User::where('id',$id)->first();
            $user->update([
                'status' => 0,
            ]);

            DB::commit();
          return redirect()->back()->with('status','User Deactivated');  
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong');
        }
    }


    public function renewAccount($id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            // dD($id);
            $user = User::where('id',$id)->first();
            $user->update([
                'can_access' => 1,
                'subscription_date' =>Carbon\Carbon::now(),
            ]);
              DB::commit();
            return redirect()->back()->with('status','Your Account has been renewed');  
        } catch (Exception $e) {
             DB::rollback();
             return redirect()->back()->with('error','Something went wrong');  
        }
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required', 'string', 'min:8', 'confirmed',
        ]);
        DB::beginTransaction();

        try {
            $user = User::where('id',$request->user_id)->first();
            $user->update([
                'password' => Hash::make($request->password),
            ]);
              DB::commit();
            return redirect()->back()->with('status','Password hass been changed for' .$user->name);  
        } catch (Exception $e) {
             DB::rollback();
             // dD($e);
             return redirect()->back()->with('error','Something went wrong');  
        }
    }

     public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            $user = User::where('id',$id)->first();
            $user->delete();
            DB::commit();
          return redirect()->back()->with('status','User Deleted');  
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong');
        }
    }


}
