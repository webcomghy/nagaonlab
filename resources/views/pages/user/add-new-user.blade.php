@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Table List')])

<style>
    /* generate serial no */
    body {
        counter-reset: Serial;
        /* Set the Serial counter to 0 */
    }

    table {
        border-collapse: separate;
    }

    tr td:first-child:before {
        counter-increment: Serial;
        /* Increment the Serial counter */
        content: counter(Serial);
        /* Display the counter */
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

    .alert-success {
        color: #fff;
        background-color: #83a584;
        border-color: #83a884;
    }
</style>

@section('content')
<div class="content">

    {{-- table --}}
    <div class="container-fluid  col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between">
                <h3 class="card-title">Users</h3>
                <a href="#" class="btn btn-info btn-sm button" data-toggle="modal" data-target="#myModal">Add New User</a>
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
                <div class="table-responsive ">
                    <table class="table table-hover ">
                        <thead class="text-primary">
                            <th>SL</th>
                            <th>Username</th>
                            <th>Name</th>
                            {{-- <th>Address</th> --}}
                            <th>Mobile</th>
                            <th>Valid Upto</th>
                            <th>Action</th>

                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                            <tr @if($user->status == 0) style="background-color: #ff000033;"  @endif>
                                <td> </td>
                                <td>{{ $user->username ?? '' }}</td>
                                <td>{{ $user->name }}</td>
                                {{-- <td>{{ $user->address }}</td> --}}
                                <td>{{ $user->phone }}</td>
                                <td>
                                    @php                                       
                                        $date = DB::table('users')->where('id', $user->id)->value('subscription_date');
                                        $createdDate = \Carbon\Carbon::parse($date);

                                        // Get the current date and time
                                        $currentDate = \Carbon\Carbon::now();

                                        // Calculate one year later
                                        $oneYearLater = $createdDate->copy()->addYear();

                                        // Calculate the number of days remaining
                                        $daysRemaining = $currentDate->diffInDays($oneYearLater);
                                    @endphp

                                    <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="{{ $daysRemaining }} days remaining" >{{ date('d-m-Y h:i a', strtotime($oneYearLater))}}</span><br/>
                                    @if( $daysRemaining == 0)
                                        <span class="badge badge-danger">Subscription Ended</span>
                                       {{--  @php
                                            $user = App\Models\User::where('id',$user->id)->update([
                                                'can_access' => 0,
                                            ])
                                        @endphp --}}
                                    @endif
                                </td>

                                <td style="display: flex;">
                                   
                                   <a href="{{route('user.delete',Crypt::encrypt($user->id))}}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user ?')">Delete</a>

                                    <a href="{{route('change-password')}}" class="btn btn-outline-info btn-sm" data-toggle="modal"
                                          style="margin-right:.6rem;"  data-target="#editinvestigations{{$user->id}}"> Change Password</a>
                                           
                                            <div class="modal fade" id="editinvestigations{{$user->id}}" role="dialog">
                                                <div class="modal-dialog modal-lg">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h2 class="modal-title">Change Password</h2>
                                                            <div>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="container-fluid">
                                                                <form action="{{route('change-password')}}" method="post">
                                                                     {{ csrf_field() }}
                                                                    {{ method_field('POST') }}

                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-12">
                                                                            <label>New Password</label>
                                                                            <input type="password" class="form-control" name="password" value="">
                                                                            <input type="hidden" class="form-control" name="user_id" value="{{$user->id}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-12">
                                                                            <label>Confirm Password</label>
                                                                            <input type="password" class="form-control" name="confirm-password" value="">
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

                                    @if($user->status == 1)

                                        <a href="{{route('user.deactivate',Crypt::encrypt($user->id))}}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to deactivate this user ?')">Deactivate</a>
                                    @else
                                         <a href="{{route('user.activate',Crypt::encrypt($user->id))}}" class="btn btn-outline-primary btn-sm" onclick="return confirm('Are you sure you want to activate this user ?')">Activate</a>
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
{{-- </div> --}}

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="modal-title">Add New User</h2>
                <div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <div class="modal-body">

                <div class="container-fluid" style="padding:inherit;">
                    <form action="{{ route('user.store-new') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Enter Name</label>
                                <input type="text" class="form-control" name="name">
                                @error('name')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label> Enter Address</label>
                                <input type="text" class="form-control" name="address">
                                @error('address')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label> Enter Mobile</label>
                                <input type="text" class="form-control" name="mobile">
                                @error('mobile')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Enter Email</label>
                                <input type="text" class="form-control" name="email">
                                @error('email')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label> Enter Password</label>
                                <input type="password" class="form-control" name="password">
                                @error('password')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation">
                                @error('password_confirmation')
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
    <script type="text/javascript">
         // JavaScript to activate tooltips
     $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>
@endpush
