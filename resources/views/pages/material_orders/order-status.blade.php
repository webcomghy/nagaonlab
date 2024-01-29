@extends('layouts.app', ['activePage' => 'materialorders', 'titlePage' => __('Order Status')])
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

    .transaction-layout {
  max-width: 800px;
  margin: 20px auto;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  padding: 20px;
}

.transaction-header {
  text-align: center;
  margin-bottom: 20px;
}

.transaction-timeline {
  position: relative;
  padding-left: 30px;
}

.timeline-item {
  margin-bottom: 20px;
  display: flex;
}

.timeline-content {
  flex: 1;
  background-color: #f5f5f5;
  padding: 15px;
  border-radius: 8px;
}

.timeline-marker {
  position: absolute;
  top: 10px;
  left: 0;
  width: 10px;
  height: 10px;
  background-color: #007bff;
  border-radius: 50%;
}
</style>
@endsection

@section('content')
<div class="content">
    <div class="container-fluid  col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between">
                <h3 class="card-title">Orders</h3>
                <a href="{{route('price.list.index')}}" class="btn btn-info btn-sm button">Order New Item</a>
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
                            <th>Date</th>
                            {{-- <th>Order No</th> --}}
                            <th>Order By</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order )
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{date('d-m-Y',strtotime($order->created_at))}}</td>
                                    {{-- <td>{{$order->order_no}}</td> --}}
                                    <td>
                                      @php
                                        $user = App\Models\User::where('id', $order->user_id)->value('name');
                                      @endphp
                                      {{$user}}</td>
                                    <td>{{App\Helper\CommonHelper::getItemName($order->item_id)}}</td>
                                    <td>{{$order->quantity}}</td>
                                    <td>{{number_format($order->total, 2)}}</td>
                                    <td>
                                        <a href="{{route('get-order-trans',Crypt::encrypt($order->id))}}" class="btn btn-info btn-sm">Check Status</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>



            </div>
        </div>

        <!-- The modal -->

        

    </div>
</div>


@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-fzff82+8pzHnwA1mQ0dzz9/E0B+ZRizq08yZfya66INZBz86qKTCt9MLU0NCNIgaMJCgeyhujhasnFUsYMsi0Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/fontawesome.min.js" integrity="sha512-vF2g7ozd8M2AA8re3eCrfJT2vvrOmIbW9JhodInQHN5Xjg6ec6nJpMJQcwuXm+aOhQze+CrM2rFQLftMtQA+bA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>



@endpush
