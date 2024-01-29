@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('Health Care Laboratory')])

<style>
.container {
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
  padding-top: 60px !important;
}
</style>

@section('content')
	<div class="col-md-9 ml-auto mr-auto mb-3 text-center">
			{{-- <h2 style="text-transform: uppercase; font-weight: 600;">{{ __('Health Care Laboratory') }} </h2> --}}
		<img src="{{asset('material')}}/img/logo.jpeg" style="max-width: 27rem;height: 8rem;">
	</div>
	<div class="container">
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

		<div class="row ">
			<div class="col-lg-6 col-md-8 col-sm-12 ml-auto mr-auto">
				 
				<form class="form" method="POST" action="{{ route('login') }}">
					@csrf

					<div class="card card-login card-hidden mb-3">
						<div class="card-header card-header-primary text-center">
							<h4 class="card-title"><strong>{{ __('Login') }}</strong></h4>
							{{-- <div class="social-line">
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                    <i class="fa fa-facebook-square"></i>
                                </a>
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </div> --}}
						</div>
						<div class="card-body">
							{{-- <p class="card-description text-center">{{ __('Or Sign in with ') }} {{ __(' and the password ') }}</p> --}}
							<div class="bmd-form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="material-icons">email</i>
										</span>
									</div>
									<input type="text" name="username" class="form-control" placeholder="Username" required>
								</div>
								@if ($errors->has('username'))
									<div id="email-error" class="error text-danger pl-3" for="username" style="display: block;">
										<strong>{{ $errors->first('username') }}</strong>
									</div>
								@endif
							</div>
							<div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="material-icons">lock_outline</i>
										</span>
									</div>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
								</div>
								@if ($errors->has('password'))
									<div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
										<strong>{{ $errors->first('password') }}</strong>
									</div>
								@endif
							</div>
                            
						</div>
						<div class="card-footer justify-content-center">
							<div>
                                <button type="submit" class="btn btn-primary btn-sm ">{{ __('Sign In ') }}</button>
                            </div>
                            {{-- <div>
                                <a href="https://webcomindia.biz/">Web.Com (India)</a>
                            </div> --}}
						</div>
					</div>
				</form>
			</div>
			
		</div>
	</div>
@endsection
