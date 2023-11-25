@include('layouts.header')
<!--Main Header -->

<!-- Sidemenu -->
@include('layouts.sidebar')
<!-- End Sidemenu -->
</div>


		<!-- Main Content-->
		<div class="main-content side-content pt-0">
			<div class="side-app">

			  <div class="main-container container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div>
						<h2 class="main-content-title tx-24 mg-b-5">Users</h2>
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
							<li class="breadcrumb-item active" aria-current="page">users</li>
						</ol>
					</div>
					<div class="btn-list">
						<a class="btn ripple btn-primary" href="javascript:void(0);"><i class="fe fe-external-link"></i> Export</a>
						<a class="btn ripple btn-danger dropdown-toggle" href="javascript:void(0);" data-bs-toggle="dropdown"
							aria-haspopup="true" aria-expanded="true">
							<i class="fe fe-settings"></i> Settings <i class="fa fa-caret-down ms-1"></i>
						</a>
						<div class="dropdown-menu tx-13">
							<a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-eye me-2 float-start"></i>View</a>
							<a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-plus-circle me-2 float-start"></i>Add</a>
							<a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-mail me-2 float-start"></i>Email</a>
							<a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-folder-plus me-2 float-start"></i>Save</a>
							<a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-trash-2 me-2 float-start"></i>Remove</a>
							<a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i class="fe fe-settings me-2 float-start"></i>More</a>
						</div>
					</div>
				</div>
				<!-- End Page Header -->

                <!-- Row -->
					<div class="row row-sm">
						<div class="col-sm-6 col-xl-3 col-lg-6">
							<div class="card custom-card">
								<div class="card-body dash1">
									<div class="d-flex">
										<p class="mb-1 tx-inverse">All Users</p>
										<div class="ms-auto">
											<h3 class="dash-25">568</h3>
										</div>
									</div>
									<div>
                                        <a class="btn ripple btn-primary" href="javascript:void(0);"><i class="fe fe-eye"></i> View</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-xl-3 col-lg-6">
							<div class="card custom-card">
								<div class="card-body dash1">
									<div class="d-flex">
										<p class="mb-1 tx-inverse">Active Users</p>
										<div class="ms-auto">
											<h3 class="dash-25">100</h3>
										</div>
									</div>
									<div>
                                        <a class="btn ripple btn-primary" href="javascript:void(0);"><i class="fe fe-eye"></i> View</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-xl-3 col-lg-6">
							<div class="card custom-card">
								<div class="card-body dash1">
									<div class="d-flex">
										<p class="mb-1 tx-inverse">Inactive Users</p>
										<div class="ms-auto">
											<h3 class="dash-25">100</h3>
										</div>
									</div>
									<div>
										<a class="btn ripple btn-secondary" href="javascript:void(0);"><i class="fe fe-eye"></i> View</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-xl-3 col-lg-6">
							<div class="card custom-card">
								<div class="card-body dash1">
									<div class="d-flex">
										<p class="mb-1 tx-inverse">New Users</p>
										<div class="ms-auto">
											<h3 class="dash-25">100</h3>
										</div>
									</div>
									<div>
                                        <a class="btn ripple btn-primary" href="javascript:void(0);"><i class="fe fe-eye"></i> View</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--End  Row -->


				<!-- Row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="card custom-card overflow-hidden">
							<div class="card-body">
								<div class="card-header border-bottom-0 p-0">
									<h6 class="card-title mb-1">Users Information</h6>
									<p class="text-muted card-sub-title">All users can be found on this table</p>
								</div>
								<div class="table-responsive">
									<table class="table" id="example1">
										<thead>
											<tr>
												<th class="wd-20p">Email</th>
												<th class="wd-25p">Phone Number</th>
												<th class="wd-20p">Registration Date</th>
												<th class="wd-15p">Account Status</th>
												<th class="wd-20p">Last Login</th>
                                                <th class="wd-20p">Actions</th>
											</tr>
										</thead>
										<tbody>
											@forelse ($users as $user)
                                            <tr>
												<td>{{$user->email ?? 'Not available'}}</td>
												<td>{{$user->phone_number ?? 'Not available'}}</td>
												<td>{{ $user->created_at }}</td>
												<td class="text-primary">Active</td>
												<td>{{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                                                <td class="text-primary" style="display:flex; gap:2px;">
                                                    <a class="btn ripple btn-primary" href="{{route('user', $user->id)}}"><i class="fe fe-eye"></i></a>
                                                    {{-- <a class="btn ripple btn-secondary" href="javascript:void(0);"><i class="fe fe-edit"></i></a> --}}
                                                    <a class="btn ripple btn-danger" href="javascript:void(0);"><i class="fe fe-trash"></i></a>
                                                </td>

											</tr>

                                            @empty
                                            <tr>
                                                No Users
											</tr>

                                            @endforelse

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Row -->
			</div>
		</div>
		<!-- End Main Content-->






















<!-- Sidebar -->

<!-- End Sidebar -->

<!-- Main Footer-->
@include('layouts.footer')

<!-- Chart.Bundle js-->
<script src="/assets/plugins/chart.js/Chart.bundle.min.js"></script>

<!-- Dashboard js-->
<script src="/assets/js/index.js"></script>


<!-- DATA TABLE JS-->
<script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
<script src="../assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
<script src="../assets/js/table-data.js"></script>
<script src="../assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
<script src="../assets/plugins/datatable/js/jszip.min.js"></script>
<script src="../assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
<script src="../assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
<script src="../assets/plugins/datatable/js/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatable/js/buttons.print.min.js"></script>
<script src="../assets/plugins/datatable/js/buttons.colVis.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.responsive.min.js"></script>
<script src="../assets/plugins/datatable/responsive.bootstrap5.min.js"></script>

