@extends('layouts.app', ['activePage' => 'typography', 'titlePage' => __('Typography')])
<style>
    /* generate serial no */
    body {
        counter-reset: Serial;
        /* Set the Serial counter to 0 */
    }

    table {
        border-collapse: separate;
    }

    /* tr td:first-child:before {
        counter-increment: Serial;
        content: counter(Serial);
        
    } */

    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .main-panel>.content {
        margin-top: 30px !important;
        padding: 30px 15px;
        min-height: calc(100vh - 123px);
    }

    .button {
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
                <h3 class="card-title">Core Investigations</h3>
                @if (auth()->user()->investigations == 1)
                <a href="" class="btn btn-info btn-sm button" data-toggle="modal" data-target="#myModal">Add Investigation</a>
                @endif

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
                    <form action="{{ route('investigation') }}" method="GET">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="text-dark">Search Investigation</label>
                                        <input type="text" name="inv" class="form-control" required value="{{Request()->get('inv')}}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="">
                                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top:20px">Search</button>
                                        <a href="{{ route('investigation') }}" class="btn btn-warning  btn-sm" style="margin-top:20px">Reset</a>
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
                            <th>Investigation</th>
                            <th>Code</th>
                            <th>B2B Price</th>
                            <th>B2C Price</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>TAT</th>
                            @if (auth()->user()->type == 'M')
                            <th>Action</th>
                            @endif

                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$datas)
                            <tr>
                                <td>{{$data->firstItem() + $key }}</td>
                                {{-- <td>{{$datas->core}}</td> --}}
                                <td>{{$datas->investname}}</td>
                                <td>{{$datas->code}}</td>
                                <td>{{$datas->b2b_price}}</td>
                                <td>{{$datas->b2c_price}}</td>
                                <td>
                                    @php
                                    $type = DB::table('investigation_types')->where('id',$datas->type)->first();
                                    @endphp
                                    {{$type->name ?? ''}}
                                </td>
                                <td>{{$datas->quantity}}</td>
                                <td>{{$datas->tat}}</td>
                                @if (auth()->user()->type == 'M')
                                <td style="display: flex;">
                                    <a href="{{url('masters/edit-investigation/'.$datas->id)}}" class="btn btn-outline-info btn-sm" data-toggle="modal" style="margin-right:.6rem;" data-target="#editinvestigations{{$datas->id}}"> Edit</a>
                                    {{-- edit modal --}}
                                    <div class="modal fade" id="editinvestigations{{$datas->id}}" role="dialog">
                                        <div class="modal-dialog modal-lg">

                                            <!-- Modal content-->
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h2 class="modal-title">Edit Core Investigations</h2>
                                                    <div>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="container-fluid">
                                                        <form action="{{url('masters/update-investigation/'.$datas->id)}}" method="post">
                                                            {{ csrf_field() }}
                                                            {{ method_field('PUT') }}

                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    {{-- <label>Edit Core Investigations</label> --}}
                                                                    <input type="hidden" class="form-control" name="core" value="LAB">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <label> Edit Name of Investigations</label>
                                                                    <input type="text" class="form-control" name="investname" value="{{$datas->investname}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <label> Edit Code of Investigations</label>
                                                                    <input type="text" class="form-control" name="code" value="{{$datas->code}}">
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label> Edit B2B Price of Investigations</label>
                                                                    <input type="number" class="form-control" name="b2b_price" value="{{$datas->b2b_price}}">
                                                                </div>
                                                                {{-- </div>
                                                                     <div class="form-row"> --}}
                                                                <div class="form-group col-md-6">
                                                                    <label> Edit B2C Price of Investigations</label>
                                                                    <input type="number" class="form-control" name="b2c_price" value="{{$datas->b2c_price}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <label>Investigation Type</label>
                                                                    <select class="form-control" name="type">
                                                                        <option value="">Select</option>
                                                                        @foreach($types as $type)
                                                                        <option value="{{$type->id}}" {{$type->id == $datas->type ? 'selected' : ''  }}>{{$type->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <label> Edit Quantity</label>
                                                                    <input type="text" class="form-control" name="quantity" value="{{$datas->quantity}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <label> Edit TAT (Turned Arounfd Time)</label>
                                                                    <input type="text" class="form-control" name="tat" value="{{$datas->tat}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 offset-4">
                                                                <button type="submit" class="btn btn-primary btn-sm" style="margin-top:20px">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                                {{-- <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal"></button>
                                                        </div> --}}
                                            </div>

                                        </div>
                                    </div>

                                    <form action="{{url('masters/investigation/'.$datas->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class=" btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure ?')">Delete</button>
                                    </form>
                                </td>
                                @endif

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
</div>


{{-- modal --}}
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="modal-title">Add Core Investigations</h2>
                <div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <div class="modal-body">

                <div class="container-fluid">
                    <form action="{{ url('masters/investigation') }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}

                        <div class="container">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    {{-- <label >Core Investigations</label> --}}
                                    <input type="hidden" class="form-control" name="core" value="LAB">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Name of Investigations</label>
                                    <input type="text" class="form-control" name="investname">
                                    @error('investname')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Code of Investigations</label>
                                    <input type="text" class="form-control" name="code">
                                    @error('code')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label> B2B Price</label>
                                    <input type="number" class="form-control" name="b2b_price">
                                    @error('b2b_price')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label> B2C Price</label>
                                    <input type="number" class="form-control" name="b2c_price">
                                    @error('b2c_price')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Investigation Type</label>
                                    <select class="form-control" name="type">
                                        <option value="">Select</option>
                                        @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control" name="quantity">
                                    @error('quantity')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Enter TAT (Turned Around Time)</label>
                                    <input type="text" class="form-control" name="tat">
                                    @error('tat')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 offset-4">
                                <button type="submit" class="btn btn-primary btn-sm" style="margin-top:20px">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            {{-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"></button>
            </div> --}}
        </div>

    </div>
</div>

@endsection