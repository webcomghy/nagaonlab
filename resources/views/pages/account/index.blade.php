@extends('layouts.app', ['activePage' => 'typography', 'titlePage' => __('Typography')])
  <style>
        /* generate serial no */
     body
    {
        counter-reset: Serial;           /* Set the Serial counter to 0 */
    }

    table
    {
        border-collapse: separate;
    }

    tr td:first-child:before
    {
    counter-increment: Serial;      /* Increment the Serial counter */
    content: counter(Serial); /* Display the counter */
    }

    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number]{
        -moz-appearance: textfield;
    }
    .main-panel>.content {
        margin-top: 30px !important;
        padding: 30px 15px;
        min-height: calc(100vh - 123px);
    }
     .button{
    float: right;
    margin-left: -50%;
    margin-top: 2em;
    }

    .error {
        color: red;
        font-size: 15px;
    }
 </style>


@section('content')
<div class="content">

        <div class="container-fluid col-md-12 col-lg-12">
            <div class="card col-sm-12">
                <div class="card-header card-header-primary d-flex justify-content-between">
                    <h3 class="card-title">Account Transaction</h3>
                    <!-- <a href="" class="btn btn-info btn-sm button" data-toggle="modal" data-target="#myModal" >Add New</a> -->
                </div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="material-icons">close</i>
                                    </button>
                                    <span>{{ session('status') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div style="margin:2rem;">
                    <form action="{{ route('accounts.index') }}" method="GET">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="text-dark">From Date</label>
                                            <input type="date" name="from_date" class="form-control" required value="{{Request()->get('from_date')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label class="text-dark">To Date</label>
                                        <input type="date" name="to_date" class="form-control" required value="{{Request()->get('to_date')}}">
                                    </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary btn-sm" style="margin-top:20px">Search</button>
                                            <a href="{{route('accounts.index')}}" class="btn btn-warning  btn-sm" style="margin-top:20px">Reset</a>
                                        </div>
                                    </div>
                                </div>
                                                                
                            </div>  
                            

                        </div>
                    </form>
                </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class=" text-primary">
                                <th>SL</th>
                                <th>Date</th>
                                <th>User Name</th>
                                <th>Type</th>
                                <th style="text-align: right;">Credit</th>
                                <th style="text-align: right;">Debit</th>
                               
                            </thead>
                            <tbody>
                                @forelse($trans as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{date('d-m-Y',strtotime($data->created_at))}}</td>
                                        <td>
                                        	@php
                                        		$center = DB::table('users')->where('id',$data->coll_center_id)->first();
                                        	@endphp
                                            {{$center->username ?? ucwords($center->name)}}
                                        </td>

                                        <td>
                                            @php
                                                if($data->ledger_type == 'WR'){
                                                    $name = 'Wallet Recharge';
                                                }elseif($data->ledger_type == 'PB'){
                                                    $name = 'Patient Billing';
                                                }elseif($data->ledger_type == 'PB'){
                                                    $name = 'Patient Billing';
                                                }elseif($data->ledger_type == 'MB'){
                                                    $name = 'Material Billing';
                                                }
                                            @endphp
                                            {{$name ?? ''}}
                                        </td>
                                        <td style="text-align: right;">{{$data->credit}}</td>
                                        <td style="text-align: right;">{{$data->debit}}</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <th style="text-align: center;" colspan="5">No data</th>
                                    </tr>
                                @endforelse
                               
                            </tbody>
                            <tfoot>
                            	<tr>
                            		<th colspan="4" style="text-align: center;">Total</th>
                            		<th style="text-align: right;">{{ number_format($trans->sum('credit'), 2, '.', ',') }}</th>
                            		<th style="text-align: right;">{{number_format($trans->sum('debit'), 2, '.', ',')}}</th>
                            	</tr>
                            </tfoot>
                        </table>
                        
                    </div>
                </div>                   
            </div>            
        </div>

@endsection
