@extends('layouts.app', ['activePage' => 'patientdetails', 'titlePage' => __('Patient Details')])

<style>
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

	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	input[type=number] {
		-moz-appearance: textfield;
	}

	a .material-icons {
		vertical-align: middle !important;
	}

	.btn .material-icons,
	.btn:not(.btn-just-icon):not(.btn-fab) .fa {
		position: relative;
		display: inline-block;
		top: 9px !important;
		margin-top: -1em;
		margin-bottom: -1em;
		font-size: 1.1rem;
		vertical-align: middle;
	}

	.btn.btn-sm,
	.btn-group-sm>.btn,
	.btn-group-sm .btn {
		padding: none !important;
		font-size: 0.688rem;
		line-height: 1.5;
		border-radius: 0.2rem;
	}

	.modal-dialog {
		max-width: 715px !important;
		margin: 1.75rem auto;
	}
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/fontawesome.min.css" integrity="sha512-r9kUVFtJ0e+8WIL8sjTUlHGbTLwlOClXhVqGgu4sb7ILdkBvM2uI+n/Fz3FN8u3VqJX7l9HLiXqXxkx2mZpkvQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@section('content')
<div class="content">
	<div class="container-fluid  col-md-12 col-lg-12">
		<div class="card">
			<div class="card-header card-header-primary d-flex justify-content-between">
				<h3 class="card-title">Patient List </h3>
				@if(auth::user()->type != 'FD')
				<a href="{{ url('masters/add-patient-details') }}" class="btn btn-info btn-sm button">Add New Case</a>
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
				@elseif(session('error'))
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<i class="material-icons">close</i>
							</button>
							<span>{{ session('error') }}</span>
						</div>
					</div>
				</div>
				@endif
				<div style="margin:2rem;">
					<form action="{{ route('patientdetails') }}" method="GET">
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
											<a href="{{route('patientdetails')}}" class="btn btn-warning  btn-sm" style="margin-top:20px">Reset</a>
										</div>
									</div>
								</div>
																
							</div>	
							

						</div>
					</form>
				</div>
				<div class="table-responsive">
					{{-- search --}}
					{{-- <div class="mx-auto pull-right">
							<div class="">

							</div>
						</div> --}}

					{{-- table --}}
					<ol>
						<table class="table table-hover" id="case">
							<thead class=" text-primary">
								<th>Case Id</th>
								<th>Name</th>
								<th>Gender</th>
								{{-- <th>Age</th> --}}
								<th>M. Number</th>
								<th>Source</th>
								<th>Status</th>
								<th>Actions</th>

							</thead>
							<tbody>
								@foreach ($patientdetails as $key => $data)
								<tr>
									
									<td>{{ $data->case_id }}</td>
									<td>{{ $data->title }} {{ $data->fname }} {{ $data->lname }}</td>
									<td>{{ $data->gender }}</td>
									{{-- <td>{{ $data->years }}yrs </td> --}}
									<td>{{ $data->mobile }}</td>
									<td>
										@php
											$user = DB::table('users')->where('id',$data->created_by)->value('name');
										@endphp
										{{$user}}
									</td>
									<td>
										@if(isset($data->status))
												@php
													$status = DB::table('statuses')->where('id',$data->status)->first();
												@endphp

												<span class="{{$status->badge}}">{{ $status->name }}</span> 
												@if($data->status_remarks != NULL)
													<a href="#" class="report-link" data-id="{{$data->id}}">
													  <i class="material-icons" style="margin-top: .2rem;">info</i>
													</a>
												@endif
										@endif
									</td>
									<td style="display:flex;">
										 <!-- <a href="{{ url('masters/patient-details-receipt/' . $data->id) }}" type="button" target="_blank"style="margin-right:.6rem;" class="btn btn-outline-success btn-sm">Receipt</a>  -->
										<a href="{{route('get-test-details',Crypt::encrypt($data->id)) }}" class="btn btn-outline-info btn-sm" style="margin-right:.6rem;" ><i class="fa fa-info">pen</i></a>

										<a href="{{ url('masters/add-new-test/' . $data->id) }}" type="button" style="margin-right:.6rem;" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></a>

										@if( auth::user()->edit_permission == 1)
										<a href="{{route('edit-patient-details',Crypt::encrypt($data->id)) }}" style="margin-right:.6rem;" type="submit" class="btn btn-outline-info btn-sm"> <i class="fa fa-pen">pen</i></a>
										@endif
										@if( auth::user()->update_status == 1)
										<a href="{{ url('masters/edit-status/'.$data->id) }}" style="margin-right:.6rem;" type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#updateStatus{{ $data->id }}">Status</a>

										<div class="modal fade" id="updateStatus{{ $data->id }}" role="dialog">
											<div class="modal-dialog modal-sm">
												<div class="modal-content">
													<div class="modal-header">
														<h2 class="modal-title">Update Status</h2>
														<div>
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div>
													</div>
													<div class="modal-body">
														<form action="{{ url('masters/update-new-status/' . $data->id) }}" method="POST" enctype="multipart/form-data">
															{{ csrf_field() }}
															{{ method_field('PUT') }}
															<div class="container-fluid">
																<div class="form-group">
																	<label class="text-dark">Status</label>

																	<select class="form-control" name="status" required>
																		@php
																		$status = DB::table('statuses')->where('status',1)->where('id','!=','1')->where('deleted_at','=',NUll)->get();
																		@endphp
																		<option value="">Select Status</option>
																		@foreach ($status as $s )
																		<option value="{{$s->id}}">{{$s->name}}</option>
																		@endforeach
																		{{-- <option value="VERIFIED">Verified</option>
																				<option value="REJECTED">Rejected</option>
																				<option value="PAYMENT PENDING">Payment Pending</option>
																				<option value="PAYMENT DONE">Payment Done</option>
																				<option value="REPORT READY">Report ready</option> --}}
																	</select>
																</div>
																<div class="form-group">
																	<label class="text-dark">Remark</label>
																	<textarea class="form-control" name="remarks" rows="4" required></textarea>

																</div>
																<div class="form-group">
																	<label class="text-dark">Add File</label>
																	<div class="custom-file">
																		 <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="inputGroupFile{{ $data->id }}" aria-describedby="inputGroupFileAddon{{ $data->id }}" name="file">
                                                <label class="custom-file-label" for="inputGroupFile{{ $data->id }}">Choose file</label>
                                            </div>
																	</div>																		 
																</div>
																{{-- <div class="form-group">
																	<div id="file-upload-filename"></div>
																</div> --}}


																<div class="col-md-6 offset-5">
																	<button type="submit" class="btn btn-primary btn-sm" style="margin-top:20px">Update</button>
																</div>

															</div>
														</form>
													</div>

												</div>
											</div>
										</div>

										@endif
										@if( auth::user()->delete_permission == 1)
										<form action="{{ url('masters/patient-details/' . $data->id) }}" method="post">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-outline-danger btn-sm" style="margin-right:.6rem;" onclick="return confirm('Are you sure ?')"><i class="fa fa-trash">trash</i></button>
										</form>
										@endif

											


									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
					</ol>

					<!-- The modal -->

					<div class="modal fade" id="reportModal"  role="dialog">
					    <div class="modal-dialog modal-lg">
					        <!-- Modal content-->
					        <div class="modal-content">
					            <div class="modal-header">
					                <h3 class="modal-title">Status Report</h3>
					                <div>
					                    <button type="button" class="close" data-dismiss="modal">&times;</button>
					                </div>
					            </div>
					            <div class="modal-body">
					                <div class="container-fluid" style="padding:inherit;">
					                	<div id="reportContent">
					                	 Loading...
					                	</div>
					                </div>
					            </div>
					        </div>

					    </div>
					</div>
					

				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-fzff82+8pzHnwA1mQ0dzz9/E0B+ZRizq08yZfya66INZBz86qKTCt9MLU0NCNIgaMJCgeyhujhasnFUsYMsi0Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/fontawesome.min.js" integrity="sha512-vF2g7ozd8M2AA8re3eCrfJT2vvrOmIbW9JhodInQHN5Xjg6ec6nJpMJQcwuXm+aOhQze+CrM2rFQLftMtQA+bA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

<script>
	// // $('tbody').on('mouseover', 'tr', function(){

	//     $(".testname").change(function() {
	//         //console.log('here');
	//     $(".price").val($(this).val());
	//     });

	// // });

	ChangePrice = function(obj) {

		var $this = $(obj);
		var parent = $this.parents("tr");
		var select = $this.find("option:selected").data();
		console.log(select);
		// console.log(parent.find(".price"));
		// parent.find(".price").css({
		//     "border": "2px solid red"
		// });

		parent.find(".price").val(select.price);
		// var price = parent.find($this.val());
		//console.log($this.val());
		console.log(price);

	};

	generateSerialNo = function() {
		console.log("calling generateSerialNo");
		$.each($("#core-services tbody tr"), function(index, element) {
			$(element).find("#sl").html(index + 1);
		});
	}

	removeMe = function(obj) {
		$this = $(obj);
		console.log($this.parents("table").find("tbody tr").length);
		if ($this.parents("table").find("tbody tr").length <= 1) {
			alert("At-least one record required.");
			return false;
		}
		$this.parents("tr").hide(function() {
			$(this).remove();
			// generateSerialNo();
		});
	}

	AddNewRow = function(obj) {
		console.log("AddNew Row calling");
		var html = `
            <tr>
                <td id="sl" class="sl"><li></li></td>
                <td>

                    <select class="form-control" id="investigation" name="investigation[]">
                        <option>Select Service</option>
																								@foreach ($investigation as $key => $values)
																									<option value="{{ $values }}">{{ $values }}
																									</option>
																								@endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control testname" id="testname" name="investigation_name[]" onChange="ChangePrice(this)" >
                    <option>Select Test</option>
																								@foreach ($investigation_name as $key => $values)
																									<option data-price="{{ $key }}" value="{{ $values }}">{{ $values }}</option>
																								@endforeach
                    </select>
                </td>
                <td>
                    <input type="number" step="0.01" name="price[]" id="price" class="form-control input-sm text-right price" placeholder="Price" oninput="calculatePrice(this)">
                </td>

                <td>
                    <input type="number" step="0.01" name="discount[]" id="discount" class="form-control input-sm text-right" placeholder="Discount%" oninput="calculatePrice(this)">
                </td>
                <td>
                    <input type="number" step="0.01" name="Total[]" id="ta" class="form-control input-sm text-right" placeholder="Total" >
                </td>
                <td>
                    <button class="btn btn-sm btn-danger" type="button" onclick="removeMe(this)">
                       {{-- <i class="fa fa-trash"></i> --}} X
                    </button>
                </td>
                </tr>
        `;
		$("#core-services tbody tr:last").after(html);
		// generateSerialNo();
	}

	calculatePrice = function(obj) {
		var $this = $(obj);
		var parent = $this.parents("tr");
		var price = parent.find("#price").val();
		var discount = parent.find("#discount").val();
		price = parseFloat(price);
		discount = parseFloat(discount);

		console.log("price", price, "discount", discount);
		if (isNaN(price)) {
			price = 0.00;
		}
		if (isNaN(discount)) {
			discount = 0.00;
		}
		var amnt = discount / 100 * price;
		console.log(amnt);
		var ta = price - amnt;
		parent.find("#ta").val(ta.toFixed(2));
		calculateSum();
	}

	calculateSum = function() {
		var all_row_containing_ta = $("#core-services tbody").find("tr");
		var sum = 0.00;
		// console.log(all_row_containing_ta);
		$(all_row_containing_ta).each(function(index, element) {
			//  console.log($(element).find("#ta").val());
			var amount = $(element).find("#ta").val();
			sum += parseFloat(amount);

		});
		$("#tta").val(sum.toFixed(2));
	}

	// $(document).ready(function(){
	//     var adv =parseFloat($('#adv').val());
	//     var tta =parseFloat($('#tta').val());
	//     if(isNaN(adv)){
	//         adv = 0.00;
	//     }
	//     if(isNaN(tta)){
	//         tta = 0.00;
	//     }

	//      console.log("adv", adv, "tta",tta);
	//     // $("submit").on("click", function(){
	//     //     var sum = a - b;

	//     // })
	// })

	calculateBalance = function() {

		var adv = parseFloat($('#adv').val());
		var tta = parseFloat($('#tta').val());
		if (isNaN(adv)) {
			adv = 0.00;
		}
		if (isNaN(tta)) {
			tta = 0.00;
		}
		// console.log("adv", adv, "tta",tta);
		var balance = tta - adv;
		// console.log(balance);
		$("#balance").val(balance.toFixed(2));
	}

	$(document).ready(function() {
	 
	  // $('.modal').modal();
	  $('.report-link').click(function() {
	    var id = $(this).data('id');
	    // alert(id);
	    fetchReportAndOpenModal(id);
	  });
	});

	function fetchReportAndOpenModal(id) {
	  $.ajax({
	    url: "{{route('get-status-report')}}", 
	    method: 'GET',
	    data: { id: id },
	    success: function(response) {
	      // console.log(response);
	      html = "";
            html += '<div class="content" style="text-align:justify;">'
                html += '<div class="row">'
                    html += '<div class="col-sm-12">'
                        html += '<p>Remarks : <strong>'+response.data.status_remarks+'</strong></p>';
                    html += '</div>'
                html += '</div>'
            html += '</div>'
           
            if (response.data.file != null) {
                    html += '<div class="row">'
                        html += '<div class="col-sm-12">'
                            html += '<p>File : <strong> <a href="'+response.data.file +'" target="_blank"> <i class="fa fa-file"></i> Download</a> </strong></p> ';
                            html += '</div>'
                    html += '</div>'
                }
            html += '</div>'

        $('#reportModal').modal('show');
        $('#reportModal .modal-body').html(html);
	      
	    },
	    error: function(error) {
	      console.error('Error fetching report:', error);
	    }
	  });
	}

	// $('#test-details').click(function() {
	//     var id = $(this).data('id');
	//     alert(id);
	//     // fetchReportAndOpenModal(id);
	//   });

	
</script>
@endpush