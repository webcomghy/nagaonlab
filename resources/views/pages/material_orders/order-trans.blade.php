@extends('layouts.app', ['activePage' => 'materialorders', 'titlePage' => __('Order Status')])
@section('css')
  <style type="text/css">
  
.timeline{
  width:800px;
  background-color:#072736;
  color:#fff;
  padding:30px 20px;
  box-shadow:0px 0px 10px rgba(0,0,0,.5);
}
.timeline ul{
  list-style-type:none;
  border-left:2px solid #094a68;
  padding:10px 5px;
}
.timeline ul li{
  padding:20px 20px;
  position:relative;
  cursor:pointer;
  transition:.5s;
}
.timeline ul li span{
  display:inline-block;
  background-color:#1685b8;
  border-radius:8px;
  padding:2px 5px;
  font-size:15px;
  text-align:center;
}
.timeline ul li .content h3{
  /*color:#34ace0;*/
  font-size:17px;
  padding-top:5px;
}
.timeline ul li .content p{
  padding:5px 0px 15px 0px;
  font-size:15px;
}
.timeline ul li:before{
  position:absolute;
  content:'';
  width:10px;
  height:10px;
  background-color:#34ace0;
  border-radius:50%;
  left:-11px;
  top:28px;
  transition:.5s;
}
.timeline ul li:hover{
  background-color:#071f2a;
}
.timeline ul li:hover:before{
  background-color:#0F0;
  box-shadow:0px 0px 10px 2px #0F0;
}

.badge-success {
    color: #ffffff;
    background-color: #4caf50;
}

.badge {
    display: inline-block;
    padding: 0.5rem !important;
    font-size: 100% !important;
    font-weight: 500;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}



.card .card-body {
    padding: 0.9375rem 0px !important;
    position: inherit !important;
}


  </style>
@endsection

@section('content')
<div class="content">
  <div class="container-fluid  col-md-12 col-lg-12">
    <div class="card">
      <div class="card-header card-header-primary d-flex justify-content-between">
        <h3 class="card-title">Transaction Details</h3>
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
        <div class="container">
          <div class="timeline">
            <ul>
              <span class="badge badge-success">Order No : {{$data->order_no}}</span>
                @foreach($data->orderTrans as $trans)
                 <li>
                  <div class="content">
                    <h3><span >{{$trans->from_name}}</span>  </h3>
                      <p>
                         Date - {{date('d, M Y',strtotime($trans->created_at))}}<br/>
                          {{$trans->description}} <br/>
                          @if($trans->file != NULL)
                           <a href="{{$trans->file}}" target="_blank" class="btn btn-primary btn-sm">Download</a>
                          @endif
                      </p>
                  </div>
                   </li>
                @endforeach
                @if(auth()->user()->type == 'M')
                    <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#updateTrans" >Update Trans</a>
                @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

 <div class="modal fade" id="updateTrans" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Update Transaction</h3>
                <div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="container-fluid" style="padding:inherit;">
                    <form action="{{route('update-trans')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}

                        <div class="form-row">
                          <div class="form-group col-md-12">
                              <label for="inputPassword4">Remarks</label>
                              <textarea class="form-control" row="4" name="description"></textarea>
                              <input type="hidden" name="order_id" class="form-control" value="{{$data->id}}">
                                @error('description')
                              <div class="error">{{ $message }}</div>
                                @enderror
                          </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputPassword4">Add File/Image</label>
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                            </div>
                            @error('name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                          
                        </div> 
                        <div class="col-md-6 offset-5">
                            <button type="submit" class="btn btn-primary btn-sm" style="margin-top:20px">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"
  integrity="sha512-fzff82+8pzHnwA1mQ0dzz9/E0B+ZRizq08yZfya66INZBz86qKTCt9MLU0NCNIgaMJCgeyhujhasnFUsYMsi0Q=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/fontawesome.min.js"
  integrity="sha512-vF2g7ozd8M2AA8re3eCrfJT2vvrOmIbW9JhodInQHN5Xjg6ec6nJpMJQcwuXm+aOhQze+CrM2rFQLftMtQA+bA=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
@endpush