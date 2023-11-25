<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		<meta name="description" content="TrackFit">
		<meta name="author" content="TrackFit">
		<meta name="keywords" content="">

		<!-- Favicon -->
		<link rel="icon" href="../assets/img/brand/favicon.ico" type="image/x-icon">

		<!-- Title -->
		<title>TrackFit</title>

		<!---bootstrap css-->
		<link id="style" href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!--- FONT-ICONS CSS -->
		<link href="/assets/css/icons.css" rel="stylesheet">

		<!---Style css-->
		<link href="/assets/css/style.css" rel="stylesheet">

        <!---Plugins css-->
        <link href="/assets/css/plugins.css" rel="stylesheet">

		<!-- Switcher css -->
		<link href="/assets/switcher/css/switcher.css" rel="stylesheet">
		<link href="/assets/switcher/demo.css" rel="stylesheet">

	</head>

	<body class="main-body ltr login-img">


		<!-- Loader -->
		<div id="global-loader">
			<img src="/assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- End Loader -->

		<!-- Page -->
		<div class="page main-signin-wrapper">

			<!-- Row -->
			<div class="row text-center ps-0 pe-0 ms-0 me-0">
				<div class=" col-xl-3 col-lg-5 col-md-5 d-block mx-auto">
					<div class="text-center mb-2">
                        {{-- <a  href="index.html">
                            <img src="/assets/img/brand/logo.png" class="header-brand-img" alt="logo">
                            <img src="/assets/img/brand/logo1.png" class="header-brand-img theme-logos" alt="logo">
                        </a>
					</div> --}}
					<div class="card custom-card">
						<div class="card-body pd-45">
							<h4 class="text-center">Signin to Your Account</h4>
							<form method="POST" action="{{route('login')}}">
                                @csrf
								<div class="form-group text-start">
									<label>Email</label>
									<input class="form-control" placeholder="Enter your email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
								</div>
								<div class="form-group text-start">
									<label>Password</label>
									<input class="form-control" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
								</div>
								<button type="submit" href="{{route('login')}}" class="btn ripple btn-main-primary btn-block">Sign In</button>
							</form>
							{{-- <div class="mt-3 text-center">
								<p class="mb-1"><a href="javascript:void(0);">Forgot password?</a></p>
								<p class="mb-0">Don't have an account? <a href="signup.html" class="text-primary">Create an Account</a></p>
							</div> --}}
						</div>
					</div>
				</div>
			</div>
			<!-- End Row -->


		</div>
		<!-- End Page -->

		<!-- Jquery js-->
		<script src="/assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap js-->
		<script src="/assets/plugins/bootstrap/popper.min.js"></script>
		<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

        <!-- Perfect-scrollbar js-->
        <script src="/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

        <!-- Custom-Switcher js -->
        <script src="/assets/js/custom-switcher.js"></script>

		<!-- Custom js-->
		<script src="/assets/js/custom.js"></script>

		<!-- Switcher js -->
		<script src="/assets/switcher/js/switcher.js"></script>

	</body>
</html>
