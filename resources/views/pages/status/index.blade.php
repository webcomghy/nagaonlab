@extends('layouts.app', ['activePage' => 'materialorders', 'titlePage' => __('Price List')])
@section('css')
<style>
    .plus-minus-input {
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    }

    .plus-minus-input .input-group-field {
    text-align: center;
    margin-left: 0.5rem;
    margin-right: 0.5rem;
    padding: 1rem;
    }

    .plus-minus-input .input-group-field::-webkit-inner-spin-button,
    .plus-minus-input .input-group-field ::-webkit-outer-spin-button {
    -webkit-appearance: none;
    appearance: none;
    }

    /* .plus-minus-input .input-group-button .circle {
    border-radius: 50%;
    padding: 0.25em 0.8em;
    } */
    .plus-minus-input .input-group-button .circle {
    border-radius: 38%;
    padding: 0.2em 0.3em;
    color: white;
    background-color: lightslategray;
    }
</style>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid  col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header card-header-primary d-flex justify-content-between">
                    <h3 class="card-title">Status List</h3>
                    <a href="" class="btn btn-info btn-sm button" data-toggle="modal" data-target="#myModal">Add New</a>
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
                    <div class="table-responsive ">
                        <table class="table table-hover ">
                            <thead class="text-primary">
                                <th>SL</th>
                                <th>Name</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                {{-- @dump(auth()->user()) --}}
                                @forelse ($status as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                           {{--  @if (auth()->user()->edit_permission == 1)
                                                <a href="{{route('price.edit-price-list',Crypt::encrypt($item->id))}}" class="btn btn-info btn-sm"><i
                                                        class="fa fa-pencil"></i></a>
                                            @endif --}}
                                            @if (auth()->user()->delete_permission == 1)
                                                <a href={{route('delete.status',Crypt::encrypt($item->id))}}"" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this status ?')"><i class="fa fa-trash"></i></a>
                                            @endif
                                           
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;"> No Records Yet</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Add New Status</h2>
                    <div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="modal-body">

                    <div class="container-fluid" style="padding:inherit;">
                        <form action="{{route('store-status')}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputPassword4">Enter Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                    @error('name')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="col-md-6 offset-5">
                                <button type="submit" class="btn btn-primary btn-sm" style="margin-top:20px">Submit</button>
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
@push('js')
    
@endpush
