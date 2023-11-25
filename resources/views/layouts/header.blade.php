<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
	<meta name="description" content="Trackfit">
	<meta name="author" content="">
	<meta name="keywords"
		content="">

	<!-- Favicon -->
	<link rel="icon" href="/assets/img/brand/favicon.ico" type="image/x-icon">

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

<body class="app sidebar-mini">


	<!-- Loader -->
	<div id="global-loader">
		<img src="/assets/img/loader.svg" class="loader-img" alt="Loader">
	</div>
	<!-- End Loader -->

	<!-- Page -->
	<div class="page">
	<div>
		<!--Main Header -->
		<div class="main-header side-header sticky">
			<div class="container-fluid main-container">
				<div class="main-header-left sidemenu">
					<a class="main-header-menu-icon" href="javascript:void(0);" data-bs-toggle="sidebar" id="mainSidebarToggle"><span></span></a>
				</div>
				<div class="main-header-left horizontal">
					<a class="main-logo" href="index.html">
						<img src="/assets/img/brand/logo.png" class="desktop-logo desktop-logo-dark" alt="dashleadlogo">
						<img src="/assets/img/brand/logo1.png" class="desktop-logo theme-logo" alt="dashleadlogo">
					</a>
				</div>
				<div class="main-header-right">
					<button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto collapsed" type="button"
						data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
						aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon fe fe-more-vertical"></span>
					</button>
					<div class="navbar navbar-expand-lg navbar-collapse responsive-navbar p-0">
						<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
							<ul class="nav nav-item header-icons navbar-nav-right ms-auto">
								<!-- Country-selector-->

								<!-- Theme-Layout -->
								<li class="dropdown  d-flex">
									<a class="nav-link icon theme-layout nav-link-bg layout-setting" href="javascript:void(0);">
										<span class="dark-layout"><i class="fe fe-moon"></i></span>
										<span class="light-layout"><i class="fe fe-sun"></i></span>
									</a>
								</li>
								<!-- Theme-Layout -->
								<li class="dropdown header-search">
									<a class="nav-link icon header-search" data-bs-toggle="dropdown" href="javascript:void(0);">
										<i class="fe fe-search"></i>
									</a>
									<div class="dropdown-menu">
										<div class="main-form-search p-2">
											<input class="form-control" placeholder="Search" type="search">
											<button class="btn"><i class="fe fe-search"></i></button>
										</div>
									</div>
								</li>

								<li class="dropdown main-profile-menu">
									<a class="main-img-user" href="javascript:void(0);" data-bs-toggle="dropdown"><img alt="avatar"
											src="/assets/img/users/1.jpg"></a>
									<div class="dropdown-menu">
										<div class="header-navheading">
											<h6 class="main-notification-title">{{auth()->user()->names}}</h6>
											<p class="main-notification-text">Admin Control</p>
										</div>
										<a class="dropdown-item border-top text-wrap" href="profile.html">
											<i class="fe fe-user"></i> My Profile
										</a>
										<a class="dropdown-item text-wrap" href="profile.html">
											<i class="fe fe-edit"></i> Edit Profile
										</a>
										<a class="dropdown-item text-wrap" href="settings.html">
											<i class="fe fe-settings"></i> Settings
										</a>
										<a class="dropdown-item text-wrap" href="timeline.html">
											<i class="fe fe-activity"></i> Activity
										</a>
										<button type="submit" class="dropdown-item text-wrap" href="{{route('logout')}}">
											<i class="fe fe-power"></i> Sign Out
										</button>
									</div>
								</li>
								<li class="dropdown header-settings">
									<a href="javascript:void(0);" class="nav-link icon" data-bs-toggle="sidebar-right"
										data-bs-target=".sidebar-right">
										<i class="fe fe-align-right"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
