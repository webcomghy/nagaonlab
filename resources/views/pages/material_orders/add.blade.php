@extends('layouts.app', ['activePage' => 'materialorders', 'titlePage' => __('Price List')]))

@section('content')
<div class="content">
    <div class="container-fluid  col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between">
                <h3 class="card-title">Edit Price List</h3>
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
                    <form action="{{route('price.list.update',Crypt::encrypt($item->id))}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Name</label>
                                <input type="text" class="form-control" name="name" value="{{$item->name}}">
                                @error('name')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                       

                            <div class="form-group col-md-6">
                                <label>Price </label>
                                <input type="text" class="form-control" name="price" value="{{$item->price}}">
                                @error('address')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
{{--                              <div class="form-group col-md-5">
                                <label>B2C Price </label>
                                <input type="text" class="form-control" name="b2c" value="{{$item->b2c}}">
                                @error('address')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div> --}}
                        </div>
                        {{-- <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Add Image</label>
                                <input type="file" class="from-control" name="file">
                                @error('name')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>


                        </div> --}}

                        <div class="col-md-6 offset-5">
                            <button type="submit" class="btn btn-primary btn-sm" style="margin-top:20px">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
