@include('layouts.navbars.navs.guest')
<div class="wrapper wrapper-full-page">
  <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('{{ asset('material') }}/img/login.jpg'); background-size: cover; background-position: top center;align-items: center;" data-color="blue">
  <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    @yield('content')
	   
  </div>
</div>
<!-- <footer class="footer">

		<a href="{{ asset('material') }}/pdf/aboutus.pdf">About Us</a>
	
		<a href="{{ asset('material') }}/pdf/Privacy-Policy.pdf">Privacy Policy</a>
	
		<a href="{{ asset('material') }}/pdf/termsofservice.pdf">Terms & Conditions</a>
	
		<a href="{{ asset('material') }}/pdf/ContactUs.pdf">Contact Us</a>
	
		<a href="{{ asset('material') }}/pdf/returnrefund.pdf">Cancellation & Refund Policy</a>
	
	<div style="display:flex;float:right;">
        <span style="color:white;background: green; padding: 0.3rem;">&copy; Health Care Laboratory</span>

    </div>
</footer> -->
