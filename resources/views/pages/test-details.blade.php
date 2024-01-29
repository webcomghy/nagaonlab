@extends('layouts.app', ['activePage' => 'patientdetails', 'titlePage' => __('Test Details')]))

@section('content')
<div class="content">
    <div class="container-fluid  col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between">
                <h3 class="card-title">Test Details</h3>
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
                <div class="container" style="margin-top:2rem;">
                    <form action="" method="" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-12"> 
                                {{-- @dd($details) --}}
                                    <table class="table table-bordered" width="50%">
                                        <tr>
                                            <th> Name </th>
                                            <td><strong> {{ $details->title }} {{ $details->fname }} {{ $details->lname }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th> Age </th>
                                            <td><strong> 
                                                    @if( $details->years)
                                                {{ $details->years }} years  @endif
                                             @if($details->months)
                                            {{ $details->months }}  months and  @endif
                                            @if($details->days)
                                            {{ $details->days }} days @endif </strong></td>
                                        </tr>
                                        <tr>
                                            <th> Gender </th>
                                            <td>
                                                @if($details->gender == 'M')
                                                    <strong> Male</strong>
                                                @elseif($details->gender == 'F')
                                                    <strong> Female</strong>
                                                @else
                                                    <strong>Others</strong>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> Ref By. - Specialization</th>
                                            <td>
                                               
                                                    @if($details->refer != 'Self')
                                                        @php
                                                            $refer = DB::table('referrer')->where('id',$details->refer)->first();
                                                        @endphp
                                                        <strong>{{$refer->doctorname}} - {{$refer->specialin}} </strong>
                                                    @else
                                                        @php
                                                            $refer = 'SELF';
                                                        @endphp
                                                        <strong>{{$refer}} </strong>
                                                    @endif
                                                    
                                            
                                                </td>
                                        </tr>
                                        <tr>
                                            <th> Case ID</th>
                                            <td><strong> {{ $details->case_id }} </strong></td>
                                        </tr>
                                        <tr>
                                            <th> Date & Time </th>
                                            <td><strong> {{date('d-m-Y H:i a', strtotime($details->created_at))  }}</strong></td>
                                        </tr> 
                                        <tr> 
                                            <th>Tests</th>
                                            <td>
                                                @foreach($details->transactions as $t)
                                                     <strong>{{$t->inv_name}}</strong>,&nbsp;
                                               
                                                @endforeach
                                            </td>   
                                        </tr>                                         
                                        
                                            
                                      
                                       
                                    </table>
                                    
                                </strong>
                                </p>
                            </div>
                        </div>                    
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
