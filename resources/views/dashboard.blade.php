@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
<style>
	.main-panel>.content {
		margin-top: 40px !important;
		padding: 30px 15px;
		min-height: calc(100vh - 123px);
	}

	.notification {
        color: #000; /* Change this to the default color you want */
        text-decoration: none; /* Remove underline by default */
    }

    /* Change the link color on hover */
    .notification:hover {
        color: #FF0000; /* Change this to the color you want on hover */
        /* You can also add other hover effects like text-decoration, background-color, etc. */
    }

</style>
@section('content')
	<div class="content">
		<div class="container-fluid">

      @if(auth::user()->can_access == 0)
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                    </button>
                    <span>Your subscription has ended. To avail the service you need to <a href="{{route('renew-account',Crypt::encrypt(auth::user()->id))}}" class="btn btn-primary btn-sm">Renew</a> your account </span>
                </div>
            </div>
        </div>
      @endif
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-warning card-header-icon">
							<div class="card-icon">
								<i class="material-icons">medication</i>
							</div>
							<p class="card-category">Cases </p>
							<h3 class="card-title">
								{{ $countcases }}
							</h3>
						</div>
						<div class="card-footer">
							<div class="stats">


							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-success card-header-icon">
							<div class="card-icon">
								<i class="material-icons">store</i>
							</div>
							<p class="card-category">Collection Centers</p>
							<h3 class="card-title"> {{ $countcenters }}</h3>
						</div>
						<div class="card-footer">

						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-danger card-header-icon">
							<div class="card-icon">
								<i class="material-icons">contacts</i>
							</div>
							<p class="card-category">Referrers </p>
							<h3 class="card-title">{{ $countreferrers }}</h3>
						</div>
						<div class="card-footer">
							<div class="stats">

							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-info card-header-icon">
							<div class="card-icon">
								<i class="material-icons">person</i>
							</div>
							<p class="card-category">Collection Agents</p>
							<h3 class="card-title">{{ $countagents }}</h3>
						</div>
						<div class="card-footer">
							<div class="stats">

							</div>
						</div>
					</div>
				</div>
			</div>
      
		{{-- <div class="row">
				<div class="col-md-4">
					<div class="card card-chart">
						<div class="card-header card-header-success">
							<div class="ct-chart" id="dailySalesChart"></div>
						</div>
						<div class="card-body">
							<h4 class="card-title">Daily Sales</h4>
							<p class="card-category">
								<span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.
							</p>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">access_time</i> updated 4 minutes ago
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card card-chart">
						<div class="card-header card-header-warning">
							<div class="ct-chart" id="websiteViewsChart"></div>
						</div>
						<div class="card-body">
							<h4 class="card-title">Email Subscriptions</h4>
							<p class="card-category">Last Campaign Performance</p>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">access_time</i> campaign sent 2 days ago
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card card-chart">
						<div class="card-header card-header-danger">
							<div class="ct-chart" id="completedTasksChart"></div>
						</div>
						<div class="card-body">
							<h4 class="card-title">Completed Tasks</h4>
							<p class="card-category">Last Campaign Performance</p>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">access_time</i> campaign sent 2 days ago
							</div>
						</div>
					</div>
				</div>
			</div>  --}}
		@if(auth::user()->can_access == 1)
			<div class="row">
		        <div class="col-lg-8 col-md-12">
		          <div class="card">
		            <div class="card-header card-header-tabs" style="background-color: #0c9d11">
		              <div class="nav-tabs-navigation">
		                <div class="nav-tabs-wrapper">
		                  {{-- <span class="nav-tabs-title">Notification:</span> --}}
		                  <ul class="nav nav-tabs" data-tabs="tabs" style="display:flex; justify-content: space-between; ">
		                    <li class="nav-item" >
		                      <a class="nav-link active" href="#profile" data-toggle="tab">
		                        <i class="material-icons">notifications</i> Notification
		                        <div class="ripple-container"></div>
		                      </a>
		                    </li>
		                    @if(auth::user()->type == 'M')
			                    <li class="nav-item">
			                    	<a class="btn btn-sm btn-secondary" href="{{route('notification.index')}}">
			                        <i class="material-icons">add</i> Add New
			                        <div class="ripple-container"></div>
			                      </a>
			                    </li>
			                @endif
		                  </ul>
		                </div>
		              </div>
		            </div>
		           <div class="card-body">
		              <div class="tab-content">
		                <div class="tab-pane active" id="profile">
		                  <table class="table">
		                    <tbody>
		                    	@foreach($notices as $data)
				                    <tr>	                      	 
				                      	<td>
				                      		@if($data->file)
				                      			<a href="{{$data->file}}" target="_blank" class="notification">{{$data->title}} - {{$data->notice}}</a>
				                      		@else
				                      			<a href="javascript:void(0)" {{-- style="color:#999999;" --}} class="notification">{{$data->title}} - {{$data->notice}}</a>
				                      		@endif 
				                      	</td>                      
				                     </tr> 
		                      	@endforeach
		                    </tbody>
		                  </table>
					</div>
		              </div>
		            </div> 
				</div>
			</div>
		@endif


	</div>
	</div>
@endsection

@push('js')
	<script>
	 $(document).ready(function() {
	  // Javascript method's body can be found in assets/js/demos.js
	  md.initDashboardPageCharts();
	 });
	</script>
@endpush
