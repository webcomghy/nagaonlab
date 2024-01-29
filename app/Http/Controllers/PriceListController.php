<?php

namespace App\Http\Controllers;

use App\Helper\CommonHelper;
use App\Models\ItemOrder;
use App\Models\OrderTransaction;
use App\Models\Ledger;
use App\Models\PriceList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;

class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = PriceList::when($request->material, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->material . '%');
        })->paginate(25);
        return view('pages.material_orders.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $item = PriceList::create([
                'name' => $request->name,
                'price' => $request->price,
                // 'code' => Str::slug($request->name),

            ]);
            if($request->hasFile('file')){
                // dd('here');
               $file = $request->file('file');
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mime_type = $finfo->file($request->file('file'));
                if (substr_count($request->file('file'), '.') > 1) {
                    return redirect()->back()->with('error', 'Doube dot in filename');
                }
                if ($mime_type != "image/png" && $mime_type != "image/jpeg") {
                    return redirect()->back()->with('error', 'File type not allowed');
                }
                $extension = $request->file('file')->getClientOriginalExtension();
                if ($extension != "jpg" && $extension != "jpeg" && $extension != "png") {
                    return redirect()->back()->with('error', 'File type not allowed');
                }

                $fileName = time() . '.' . $request->file->getClientOriginalExtension();
                Request()->file('file')->move(public_path('uploads/material/'.$item->id), $fileName);
                $file_path = asset('uploads/material') . '/'.$item->id .'/' . $fileName;
                $item->update([
                    'file'  => $file_path,
                ]);
            }
            DB::commit();
            return redirect()->back()->with('status','Item Added');
        } catch (\Throwable $th) {
            //throw $th;
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
        $decrypted = Crypt::decrypt($id);
        try {
            $item = PriceList::where('id', $decrypted)->first();
            return view('pages.material_orders.add', compact('item'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('Something went wrong');
        }

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
        $decrypted = Crypt::decrypt($id);
        DB::beginTransaction();
        try {
            $item = PriceList::where('id', $decrypted)->first();
            $item->update([
                'name' => $request->name,
                'price' => $request->price,
            ]);
            if($request->hasFile('file')){
               $file = $request->file('file');
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mime_type = $finfo->file($request->file('file'));
                if (substr_count($request->file('file'), '.') > 1) {
                    return redirect()->back()->with('error', 'Doube dot in filename');
                }
                if ($mime_type != "image/png" && $mime_type != "image/jpeg") {
                    return redirect()->back()->with('error', 'File type not allowed');
                }
                $extension = $request->file('file')->getClientOriginalExtension();
                if ($extension != "jpg" && $extension != "jpeg" && $extension != "png") {
                    return redirect()->back()->with('error', 'File type not allowed');
                }

                $fileName = time() . '.' . $request->file->getClientOriginalExtension();
                Request()->file('file')->move(public_path('uploads/material/'.$item->id), $fileName);
                $file_path = asset('uploads/material') . '/'.$item->id .'/' . $fileName;
                $item->update([
                    'file'  => $file_path,
                ]);
            }
            DB::commit();
            return redirect()->route('price.list.index')->with('status','Item Updated Sucessfully');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->back()->with('status','Something went wrong');
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
        $decrypted = Crypt::decrypt($id);
        try {
            $item = PriceList::where('id', $decrypted)->first();
            $item->delete();
            return redirect()->route('price.list.index')->with('status', 'Item Deleted Sucessfully');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('Something went wrong');
        }
    }


    public function getPrice(Request $reqeust)
    {
        $item = PriceList::find($reqeust->id); // Assuming you have an 'Item' model
        if ($item) {
            return response()->json(['data' => $item]);
        } else {
            return response()->json(['data' => null]);
        }

    }

    public function placeOrder(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'item' => 'required',
            'quantity' => 'required'
        ]);
        DB::beginTransaction();
        try {

            $currentTime = Carbon::now();
            $timestampPart = $currentTime->format('Ymd');
            $serialPart = CommonHelper::generateSerialNumber();

            $orderNumber = $timestampPart . $serialPart;

            $order = ItemOrder::create([
                'order_no' => $orderNumber,
                'user_id' => auth()->user()->id,
                'item_id' => $request->item,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'total' => $request->total,
            ]);
            $orderTransaction = OrderTransaction::create([
                'item_order_id' =>$order->id,
                'description' => 'Order Placed',
                'status' => '1',
                'from_id' => auth()->user()->id,
                'from_name' => auth()->user()->name,
                'to_id' => User::where('type', 'M')->value('id'),
                'to_name' => User::where('type', 'M')->value('name'),
            ]);
            

            if (auth()->user()->type == "CC") {
                $ledger_data = [
                    'coll_center_id' => auth()->user()->id,
                    'transaction_id' => $order->id,
                    'ledger_type'    => 'MB', // order material Billing
                    'debit'          => $request->total,
                ];
                Ledger::create($ledger_data);
                $wallet = User::where('id', auth()->user()->id)->first();
                $updated_amount = $wallet->wallet_balance - $request->total;
                $wallet->update([
                    'wallet_balance' => $updated_amount,
                ]);
            }

            DB::commit();
            return redirect()->route('get-order-status')->with('status','Order Placed Successfully');
        } catch (\Throwable $th) {
            //throw $th;
            dD($th);

            DB::rollback();
            return redirect()->back()->with('error','Something went wrong');
        }
    }
    public function getOrderStatus()
    {
        if(auth()->user()->type == 'M'){
            $orders = ItemOrder::with('orderTrans')->get();
        }else{
            $orders = ItemOrder::with('orderTrans')->where('user_id',auth()->user()->id)->get();
        }

        return view('pages.material_orders.order-status',compact('orders'));

    }

    public function getOrderTrans($id)
    {
        $id = Crypt::decrypt($id);
        $data = ItemOrder::where('id',$id)->with('orderTrans')->first();
        // dd($data);
       return view('pages.material_orders.order-trans',compact('data'));  
    }

    public function updateTrans(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
       try {
            $latest_trans = OrderTransaction::where('item_order_id',$request->order_id)->latest()->first();
            OrderTransaction::where('item_order_id',$request->order_id)->update(['status' => 0 ]);
            $up = OrderTransaction::create([
                'item_order_id' =>$request->order_id,
                'description' => $request->description,
                'status' => '1',
                'from_id' => auth()->user()->id,
                'from_name' => auth()->user()->name,
                'to_id' => $latest_trans->from_id,
                'to_name' => $latest_trans->from_name,
            ]);
            if($request->file){
               
               $file = $request->file('file');
              
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mime_type = $finfo->file($request->file('file'));
                if (substr_count($request->file('file'), '.') > 1) {
                    return redirect()->back()->with('error', 'Doube dot in filename');
                }
                if ($mime_type != "image/png" && $mime_type != "image/jpeg"  && $mime_type != "application/pdf") {

                    return redirect()->back()->with('error', 'File type not allowed');
                }
                $extension = $request->file('file')->getClientOriginalExtension();
                if ($extension != "jpg" && $extension != "jpeg" && $extension != "png" && $extension != "pdf") {
                    return redirect()->back()->with('error', 'File type not allowed');
                }

                $fileName = time() . '.' . $request->file->getClientOriginalExtension();
                Request()->file('file')->move(public_path('uploads/order-trans/'.$up->id), $fileName);
                $file_path = asset('uploads/order-trans') . '/'.$up->id .'/' . $fileName;
              
                $up->update([
                    'file'  => $file_path,
                ]);
             
            }
            DB::commit();
            return redirect()->back()->with('status','Transaction Updated');
       } catch (\Throwable $th) {
        dd($th);
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong');
       }
    }
}
