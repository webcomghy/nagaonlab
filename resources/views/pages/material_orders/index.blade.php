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
        <h3 class="card-title">Materials</h3>
        @if(auth()->user()->type == 'M')
        <a href="" class="btn btn-info btn-sm button" data-toggle="modal" data-target="#myModal">Add Items</a>
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
        @if(auth()->user()->type == 'CC' && auth()->user()->wallet_balance == 0.00)
        <div class="row">
          <div class="col-sm-12">
            <div class="alert alert-danger">
              <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                            </button> -->
              <span> Your wallet doesnt have available balance. please recharge to avail this service</span>
            </div>
          </div>
        </div>

        @endif
        <div style="margin:2rem;">
          <form action="{{route('price.list.index')}}" method="GET">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="text-dark">Search Materials</label>
                    <input type="text" name="material" class="form-control" required value="{{Request()->get('material')}}">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="">
                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top:20px">Search</button>
                    <a href="{{route('price.list.index')}}" class="btn btn-warning  btn-sm" style="margin-top:20px">Reset</a>
                  </div>
                </div>
              </div>

            </div>
          </form>
        </div>
        <div class="table-responsive ">
          <table class="table table-hover ">
            <thead class="text-primary">
              <th>SL</th>
              <th>Name</th>
              <th width="20%">Image</th>
              <th>Price</th>
              <th>Action</th>
            </thead>
            <tbody>
              @forelse ($items as $key => $item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->name}}</td>
                <td>
                  <img src="{{$item->file}}" style="width: 40%;">
                </td>
                <td>{{$item->price}}</td>

                <td>
                  @if (auth()->user()->edit_permission == 1)
                  <a href="{{route('price.edit-price-list',Crypt::encrypt($item->id))}}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                  @endif
                  @if (auth()->user()->delete_permission == 1)
                  <a href="{{route('price.delete-price-list',Crypt::encrypt($item->id))}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item ?')"><i class="fa fa-trash"></i></a>
                  @endif
                  @if (auth()->user()->type == 'CC' )
                  {{-- <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#order_modal{{$item->id}}"
                  data-id={{$item->id}}> Order Item</a> --}}
                  <a class=" btn btn-success btn-sm rescedule" data-id="{{$item->id}}" data-type="order" style="margin-left:.2rem;" data-toggle="modal" data-target="#exampleModal" href="">Order Item</a>

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
          {{$items->links()}}
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
        <h2 class="modal-title">Add Items</h2>
        <div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
      </div>
      <div class="modal-body">

        <div class="container-fluid" style="padding:inherit;">
          <form action="{{route('price.list.store')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputPassword4">Enter Name</label>
                <input type="text" class="form-control" name="name">
                @error('name')
                <div class="error">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group col-md-6">
                <label> Enter Price</label>
                <input type="text" class="form-control" name="price">
                @error('address')
                <div class="error">{{ $message }}</div>
                @enderror
              </div>

            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputPassword4">Add Image</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
              </div>
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

  </div>

</div>
</div>


@if(auth()->user()->wallet_balance > 0.00)
<div class="modal fade" id="order_modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Order Material</h3>
        <div> <button type="button" class="close" data-dismiss="modal">&times;</button></div>
      </div>
      <div class="modal-body">
        <div class="container" style="padding:2rem;">

        </div>
      </div>
    </div>
  </div>
</div>
@endif

@endsection
@push('js')
<script>
  $(document).ready(function() {
    $('.rescedule').click(function() {
      var selectedItemID = $(this).data('id');
      // alert(selectedItemID);
      $.ajax({
        url: "{{route('get-item-price')}}",
        method: 'GET',
        data: {
          id: selectedItemID
        },
        success: function(response) {
          console.log(response);
          html = "";
          html += '<form action="{{route('order')}}" method="POST" enctype="multipart/form-data">';
          html += '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
          html += '<table class="table" width="100%">';
          html += '<tr>';
          html += ' <th>Item</th>';
          html += '<th>Quantity</th>';
          html += '<th>Price</th>';
          html += ' </tr>';
          html += '<tr>';
          html += '<td>';
          html += ' <select name="item" id="" class="form-control">';
          html += '<option value="' + response.data.id + '">' + response.data.name + '</option>';
          html += '</select>';
          html += ' </td>';
          html += '<td>';
          html += ' <input class="form-control" type="text" name="quantity"  id="qty" >';
          html += ' <input class="form-control" type="hidden" name="wallet" id="wallet_balance"value="{{auth()->user()->wallet_balance}}">';
          html += ' </td>';
          html += '<td>';

          html += '<input type="text" class="form-control" style="float: right;" name="price" id="price" value="' + response.data.price + '">';
          html += '</td>';
          html += '</tr>';
          html += ' <tr>';
          html += '<th colspan="2">Total</th>';
          html += ' <td>';

          html += ' <input type="text" class="form-control" style="float: right;" id="total" name="total" readonly>';
          html += ' </td>';
          html += '</tr>';
          html += '<tr>';
          html += ' <td align="center" colspan="3">';
          html += ' <button type="submit" class="btn btn-primary btn-sm" id="order-button" style="margin-top:20px">Place Order</button>';
          html += '</td>';
          html += '</tr>';

          html += '</table>';
          html += '</form>';
          $('#order_modal').modal('show');
          $('#order_modal .modal-body').html(html);
          $('#qty').on('input', updatePrice);
        },
        error: function() {
          console.log('Error fetching Data');
        }
      });

    });


    function updatePrice() {
      const quantity = parseInt($('#qty').val());
      // alert(quantity);
      const pricePerItem = parseInt($('#price').val());
      const totalPrice = pricePerItem * quantity;
      console.log('qty', quantity);
      console.log(' price', pricePerItem);

      // $('input[name="price"]').val(totalPrice.toFixed(2));
      $('#total').val(totalPrice.toFixed(2));
      // alert(totalPrice);
      // Assuming you have a wallet amount element with id "wallet-amount"
      const walletAmount = parseFloat($('#wallet_balance').val());
      console.log(walletAmount);
      // Assuming you have an order button with id "order-button"
      const orderButton = $('#order-button');

      if (totalPrice <= walletAmount) {
        orderButton.prop('disabled', false); // Enable the order button
      } else {
        alert('Insufficient Wallet Balance. Please Recharge Your Wallet')
        orderButton.prop('disabled', true); // Disable the order button
      }

      // $('').val('');
    }
  });
</script>
@endpush