<!-- <style>
    .sidebar .nav {
        margin-top: 0 !important;
        display: block;
        overflow-y: scroll !important;
    }
</style> -->

<div id="sidebar" class="sidebar" data-color="azure" data-background-color="lightslategray">
    <!--
	Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

				Tip 2: you can also add an image using data-image tag
				data-image="{{ asset('material') }}/img/sidebar-1.jpg"-->
    <div class="logo">
        <a href="" class="simple-text logo-normal">
            {{-- <h4> {{ auth::user()->lab_name }} </h4> --}}
            {{-- <h4>Health Care Laboratory</h4> --}}
            <img src="{{asset('material')}}/img/logo.jpeg" style="width: 13rem;height: 4rem;">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            @if (auth::user()->type == 'FD')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('patientdetails') }}">
                    <i class="material-icons">info</i>
                    <p>{{ __('Case Details') }}</p>
                </a>
            </li>
            @else
            @if(auth::user()->can_access == 1)
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <i class="material-icons">lock</i>
                    <p>{{ __('Change Password') }} </p>
                </a>
            </li>
            @if (auth::user()->type == 'M')
            <li class="nav-item {{ $activePage == 'users' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('user.add-new-user') }}">
                    <i class="material-icons">edit</i>
                    <p>{{ __('User') }}</p>
                </a>
            </li>
            <li class="nav-item {{ $activePage == 'permissions' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('add-permissions') }}">
                    <i class="material-icons">edit</i>
                    <p>{{ __('Permissions') }}</p>
                </a>
            </li>

            <li class="nav-item {{ $activePage == 'status' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('status') }}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Status') }}</p>
                </a>
            </li>

            <li class="nav-item {{ $activePage == 'investigation_types' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('investigation_type.index') }}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Investigation Types') }}</p>
                </a>
            </li>

            @endif

            {{-- @if (auth::user()->coll_center == '1')
                <li class="nav-item {{ $activePage == 'collcenter' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('collcenter') }}">
                <i class="material-icons">content_paste</i>
                <p>{{ __('Collection Centers') }}</p>
            </a>
            </li>
            @endif --}}
            {{-- @if (auth::user()->investigations == '1') --}}
            <li class="nav-item{{ $activePage == 'investigation' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('investigation') }}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Investigations') }}</p>
                </a>
            </li>
            {{-- @endif --}}
            {{-- @if (auth::user()->coll_agents == '1')
                <li class="nav-item{{ $activePage == 'collectionAgents' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('collectionAgents') }}">
                <i class="material-icons">person</i>
                <p>{{ __('Collection Agents') }}</p>
            </a>
            </li>
            @endif --}}

            <li class="nav-item{{ $activePage == 'pricelist' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('price.list.index') }}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Materials') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'orderStatus' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('get-order-status')}}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Order Status') }}</p>
                </a>
            </li>

            @if (auth::user()->referrer == '1')
            <li class="nav-item{{ $activePage == 'referrer' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('referrer') }}">
                    <i class="material-icons">send</i>
                    <p>{{ __('Referrer') }}</p>
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route('patientdetails') }}">
                    <i class="material-icons">info</i>
                    <p>{{ __('Case Details') }}</p>
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">Reports<i class="material-icons"></i></a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item{{ $activePage == 'collections-report' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('collections-report') }}">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Collections Report') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'test-count' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('test-count-report') }}">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Test Count') }} </span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">Company Policies<i class="material-icons"></i></a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item{{ $activePage == 'about-us' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/aboutus.pdf" target="_blank">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('About Us') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'privacy-policy' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/Privacy-Policy.pdf" target="_blank">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Privacy Policy') }} </span>
                        </a>
                    </li>

                    <li class="nav-item{{ $activePage == 'terms-condition' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/termsofservice.pdf" target="_blank">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Terms & Condition') }} </span>
                        </a>
                    </li>

                    <li class="nav-item{{ $activePage == 'contact-us' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/ContactUs.pdf" target="_blank">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Contact Us') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'cancellation-refund' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/returnrefund.pdf" target="_blank">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Cancellation & Refund') }} </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        </li>
        @endif
        @endif

        </ul>
    </div>
</div>

<div class="mobile-logo-div">
    <img src="{{asset('material')}}/img/logo.jpeg" alt="" style="max-width:160px;">
    <button id="toggle-button">Menu</button>
</div>
<nav id="menu" class="closed">
    <div class="logo">
        <a href="" class="simple-text logo-normal">

            <img src="{{asset('material')}}/img/logo.jpeg" style="width: 13rem;height: 4rem;" class="mobile-sidebar-remove-logo">
        </a>
    </div>
    <div class="sidebar-wrapper1">
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            @if (auth::user()->type == 'FD')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('patientdetails') }}">
                    <i class="material-icons">info</i>
                    <p>{{ __('Case Details') }}</p>
                </a>
            </li>
            @else
            @if(auth::user()->can_access == 1)
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <i class="material-icons">lock</i>
                    <p>{{ __('Change Password') }} </p>
                </a>
            </li>
            @if (auth::user()->type == 'M')
            <li class="nav-item {{ $activePage == 'users' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('user.add-new-user') }}">
                    <i class="material-icons">edit</i>
                    <p>{{ __('User') }}</p>
                </a>
            </li>
            <li class="nav-item {{ $activePage == 'permissions' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('add-permissions') }}">
                    <i class="material-icons">edit</i>
                    <p>{{ __('Permissions') }}</p>
                </a>
            </li>

            <li class="nav-item {{ $activePage == 'status' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('status') }}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Status') }}</p>
                </a>
            </li>

            <li class="nav-item {{ $activePage == 'investigation_types' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('investigation_type.index') }}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Investigation Types') }}</p>
                </a>
            </li>

            @endif

            {{-- @if (auth::user()->coll_center == '1')
                    <li class="nav-item {{ $activePage == 'collcenter' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('collcenter') }}">
                <i class="material-icons">content_paste</i>
                <p>{{ __('Collection Centers') }}</p>
            </a>
            </li>
            @endif --}}
            {{-- @if (auth::user()->investigations == '1') --}}
            <li class="nav-item{{ $activePage == 'investigation' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('investigation') }}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Investigations') }}</p>
                </a>
            </li>
            {{-- @endif --}}
            {{-- @if (auth::user()->coll_agents == '1')
                    <li class="nav-item{{ $activePage == 'collectionAgents' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('collectionAgents') }}">
                <i class="material-icons">person</i>
                <p>{{ __('Collection Agents') }}</p>
            </a>
            </li>
            @endif --}}

            <li class="nav-item{{ $activePage == 'pricelist' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('price.list.index') }}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Materials') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'orderStatus' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('get-order-status')}}">
                    <i class="material-icons">label</i>
                    <p>{{ __('Order Status') }}</p>
                </a>
            </li>

            @if (auth::user()->referrer == '1')
            <li class="nav-item{{ $activePage == 'referrer' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('referrer') }}">
                    <i class="material-icons">send</i>
                    <p>{{ __('Referrer') }}</p>
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route('patientdetails') }}">
                    <i class="material-icons">info</i>
                    <p>{{ __('Case Details') }}</p>
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">Reports<i class="material-icons"></i></a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item{{ $activePage == 'collections-report' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('collections-report') }}">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Collections Report') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'test-count' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('test-count-report') }}">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Test Count') }} </span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">Company Policies<i class="material-icons"></i></a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item{{ $activePage == 'about-us' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/aboutus.pdf">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('About Us') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'privacy-policy' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/Privacy-Policy.pdf">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Privacy Policy') }} </span>
                        </a>
                    </li>

                    <li class="nav-item{{ $activePage == 'terms-condition' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/termsofservice.pdf">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Terms & Condition') }} </span>
                        </a>
                    </li>

                    <li class="nav-item{{ $activePage == 'contact-us' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/ContactUs.pdf">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Contact Us') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'cancellation-refund' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ asset('material') }}/pdf/returnrefund.pdf">
                            <i class="material-icons">dehaze</i>
                            <span class="sidebar-normal">{{ __('Cancellation & Refund') }} </span>
                        </a>
                    </li>
                </ul>
            </li>

            @endif
            @endif

        </ul>
    </div>
</nav>