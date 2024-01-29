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
                    <h3 class="card-title">Notifications</h3>
                    <a href="" class="btn btn-info btn-sm button" data-toggle="modal" data-target="#myModal" >Add New</a>
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
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class=" text-primary">
                                <th>SL</th>
                                <th>Title</th>
                                <th>Notices</th>
                                <th>File</th>
                                <!-- <th>Image</th> -->
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <!-- @if(isset($notifications)) -->
                                    @forelse($notifications as $data)
                                        <tr>
                                            <td></td>
                                            <td>{{$data->title}}</td>
                                            <td>{{$data->notice}}</td>
                                            <td>
                                                @if($data->file != NULL)
                                                    <a href="{{$data->file}}" class="btn btn-sm btn-primary">File</a>
                                                @endif
                                            </td>
                                            <td>
                                               <!--  <a href="" class="btn btn-sm btn-info">Edit</a> -->
                                                <a href="{{route('delete-notification',Crypt::encrypt($data->id))}}" class="btn btn-sm btn-danger">Delete</a>
                                                @if($data->status == 1)
                                                    <a href="{{route('unpublish-notification',Crypt::encrypt($data->id))}}" class="btn btn-sm btn-warning">Unpublish</a>
                                                @else
                                                    <a href="{{route('publish-notification',Crypt::encrypt($data->id))}}" class="btn btn-sm btn-success">Publish</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>No Notifications Found</td>
                                        </tr>
                                    @endforelse
                                <!-- @endif -->
                            </tbody>
                        </table>
                    </div>
                </div>                   
            </div>            
        </div>

         <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header">
                <h2 class="modal-title">Add Notifications</h2>
                    <div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="{{route('notification.store')}}" method="post" enctype="multipart/form-data" >
                            @csrf
                            {{ method_field('POST') }}

                            <div class="container">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <label >Title</label>
                                    <input type="text" class="form-control" name="title">
                                    @error('title')
                                      <div class="error">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Notice</label>
                                        <!-- <input type="text" class="form-control" name="notice"> -->
                                        <textarea class="form-control" name="notice"></textarea>
                                        @error('notice')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <label >File</label>
                                   <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                                    @error('file')
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
