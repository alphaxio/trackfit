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
                <h2 class="main-content-title tx-24 mg-b-5">User</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('users')}}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">user's information</li>
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
        <div class="row">
            <div class="col-xl-4 col-md-12">
                <div class="card custom-card">
                    <div class="card-body text-center">
                        <div class="main-profile-overview widget-user-image text-center">
                            <div class="main-img-user"><img alt="avatar" src="../assets/img/users/1.jpg"></div>
                        </div>
                        <div class="item-user pro-user">
                            <h4 class="pro-user-username text-dark mt-2 mb-0">{{$user->first_name}}  {{$user->last_name}}</h4>
                            @if ($user->provider_name == 'google')
                            <p class="pro-user-desc text-muted mb-3 mt-3">Authenticated by Google</p>
                            @else
                            <p class="pro-user-desc text-muted mb-1">Authenticated by Phone</p>
                            @endif
                            <a href="javascript:void(0);" class="btn ripple btn-primary btn-sm"><i class="fa fa-edit me-1"></i>Edit</a>
                            <a href="javascript:void(0);" class="btn ripple btn-secondary btn-sm"><i class="fa fa-trash me-1"></i>Delete</a>
                        </div>
                    </div>
                </div>
                <div class="card custom-card">
                    <div class="card-header custom-card-header rounded-bottom-0">
                        <div>
                            <h6 class="card-title mb-0">Contact Information</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="main-profile-contact-list main-profile-work-list">
                            <div class="media">
                                <div class="media-logo bg-light text-dark">
                                    <i class="fe fe-phone"></i>
                                </div>
                                <div class="media-body">
                                    <span>Mobile</span>
                                    <div>
                                        {{$user->phone_number ?? 'Not Available'}}
                                    </div>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-logo bg-light text-dark">
                                    <i class="fe fe-message-square"></i>
                                </div>
                                <div class="media-body">
                                    <span>Email</span>
                                    <div>
                                        {{$user->email ?? 'Not Available'}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="media">
                                <div class="media-logo bg-light text-dark">
                                    <i class="fe fe-map-pin"></i>
                                </div>
                                <div class="media-body">
                                    <span>Current Address</span>
                                    <div>
                                        San Francisco, CA
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-12">
                <div class="card custom-card main-content-body-profile">
                    <nav class="nav main-nav-line">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab1over">Overview</a>
                        <a class="nav-link" data-bs-toggle="tab" href="#tab2rev">Reviews</a>
                        <a class="nav-link" data-bs-toggle="tab" href="#tab3edit">Edit Profile</a>
                        <a class="nav-link" data-bs-toggle="tab" href="#tab4account">Account Settings</a>
                    </nav>
                    <div class="card-body tab-content h-100">
                        <div class="tab-pane active" id="tab1over">
                            <div class="main-content-label tx-13 mg-b-20">
                                Personal Information
                            </div>
                            <div class="table-responsive ">
                                <table class="table row table-borderless">
                                    <tbody class="col-lg-12 col-xl-6 p-0">
                                        <tr>
                                            <td><strong>Full Name :</strong> {{$user->first_name ?? 'Not available'}} {{$user->last_name ?? 'Not available'}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Location :</strong> UK</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Languages :</strong> English, German, Spanish.</td>
                                        </tr>
                                    </tbody>
                                    <tbody class="col-lg-12 col-xl-6 p-0">
                                        <tr>
                                            <td><strong>Website :</strong> domain.com</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email :</strong> klomitoor@domain.com</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone :</strong> +125 254 3562 </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="main-content-label tx-13 mg-b-20">
                                About
                            </div>
                            <p>simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy  when an unknown printer took a galley of type and scrambled Lorem Ipsum has been the industry's standard dummy  when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived .</p>
                            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit Lorem Ipsum has been the industry's standard dummy  when an unknown printer took a galley of type and scrambled in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                            <div class="main-content-label tx-13 mg-b-20">
                                Work &amp; Education
                            </div>
                            <div class="main-profile-work-list">
                                <div class="media">
                                    <div class="media-logo bg-success">
                                        <i class="fa fa-whatsapp"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6>UI/UX Designer at <a href="javascript:void(0);" class="text-primary">Whatsapp</a></h6><span>2016 - present</span>
                                        <p>Past Work: spruko, Inc.</p>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-logo bg-primary">
                                        <i class="fa fa-building"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6>Studied at <a href="javascript:void(0);" class="text-primary">Buffer University</a></h6><span>2002 - 2006</span>
                                        <p>Degree: Bachelor of Science in Computer Science</p>
                                    </div>
                                </div>
                            </div>
                            <div class="main-content-label tx-13 mg-b-20 mt-3">
                                Photos
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-3">
                                    <img alt="Responsive image" class="img-thumbnail border-0 p-0 br-3" src="../assets/img/media/1.jpg">
                                </div>
                                <div class="col-6 col-md-3">
                                    <img alt="Responsive image" class="img-thumbnail border-0 p-0 br-3" src="../assets/img/media/2.jpg">
                                </div>
                                <div class="col-6 col-md-3 mg-t-10 mg-sm-t-0">
                                    <img alt="Responsive image" class="img-thumbnail border-0 p-0 br-3" src="../assets/img/media/3.jpg">
                                </div>
                                <div class="col-6 col-md-3 mg-t-10 mg-sm-t-0">
                                    <img alt="Responsive image" class="img-thumbnail border-0 p-0 br-3" src="../assets/img/media/4.jpg">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2rev">
                            <div class="media mb-3">
                                <div class="main-img-user me-3"><img alt="avatar" src="../assets/img/users/5.jpg"></div>
                                <div class="media-body">
                                    <div class="media-contact-name mb-1">
                                        <h6 class="mb-0">Julia Carr<small class="text-muted mx-2"><i class="fe fe-clock"></i> Yesterday, 2:00 am</small> </h6>
                                    </div>
                                    <p class="mb-2">Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                                    <ul class="reviewnavs mb-0">
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-thumbs-up"></i> 794</a></li>
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-message-square"></i> 253</a></li>
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fa fa-share"></i> 24</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="media mb-3">
                                <div class="main-img-user me-3"><img alt="avatar" src="../assets/img/users/6.jpg"></div>
                                <div class="media-body">
                                    <div class="media-contact-name mb-1">
                                        <h6 class="mb-0">Victor	White<small class="text-muted mx-2"><i class="fe fe-clock"></i> Yesterday, 2:00 am</small> </h6>
                                    </div>
                                    <p class="mb-2">Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it?</p>
                                    <ul class="reviewnavs">
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-thumbs-up"></i> 794</a></li>
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-message-square"></i> 253</a></li>
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fa fa-share"></i> 24</a></li>
                                    </ul>
                                    <div class="media mt-3">
                                        <div class="main-img-user m-3"><img alt="avatar" src="../assets/img/users/7.jpg"></div>
                                        <div class="media-body mb-3">
                                            <div class="media-contact-name mb-1">
                                                <h6 class="mb-0">Megan Mackay<small class="text-muted mx-2"><i class="fe fe-clock"></i> Yesterday, 2:00 am</small> </h6>
                                            </div>
                                            <p class="mb-2">Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.</p>
                                            <ul class="reviewnavs">
                                                <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-thumbs-up"></i> 794</a></li>
                                                <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-message-square"></i> 253</a></li>
                                                <li><a href="javascript:void(0);"  class="me-2"><i class="fa fa-share"></i> 24</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media mb-3">
                                <div class="main-img-user me-3"><img alt="avatar" src="../assets/img/users/8.jpg"></div>
                                <div class="media-body">
                                    <div class="media-contact-name mb-1">
                                        <h6 class="mb-0">Audrey	Hudson<small class="text-muted mx-2"><i class="fe fe-clock"></i> Yesterday, 2:00 am</small> </h6>
                                    </div>
                                    <p class="mb-2">These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. </p>
                                    <ul class="reviewnavs">
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-thumbs-up"></i> 794</a></li>
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-message-square"></i> 253</a></li>
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fa fa-share"></i> 24</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="media">
                                <div class="main-img-user me-3"><img alt="avatar" src="../assets/img/users/9.jpg"></div>
                                <div class="media-body">
                                    <div class="media-contact-name mb-1">
                                        <h6 class="mb-0">Sean Grant<small class="text-muted mx-2"><i class="fe fe-clock"></i> Yesterday, 2:00 am</small> </h6>
                                    </div>
                                    <p class="mb-2">Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
                                    <ul class="reviewnavs mb-0">
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-thumbs-up"></i> 794</a></li>
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fe fe-message-square"></i> 253</a></li>
                                        <li><a href="javascript:void(0);"  class="me-2"><i class="fa fa-share"></i> 24</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab3edit">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4 main-content-label">Personal Information</div>
                                    <form class="form-horizontal">
                                        <div class="mb-4 main-content-label">Name</div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">User Name</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="User Name" value="Sonia Taylor">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">First Name</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="First Name" value="Sonia">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Last Name</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="Last Name" value="Taylor">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Designation</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="Designation" value="Web Designer">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 main-content-label">Contact Info</div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Email<i>(required)</i></label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="Email" value="klomitoor@domain.com">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Website</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="Website" value="domain.com">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Phone</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="phone number" value="+125 254 3562">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Address</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <textarea class="form-control" name="example-textarea-input" rows="2" placeholder="Address">London, UK</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 main-content-label">Social Info</div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Twitter</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="twitter" value="twitter.com/spruko.me">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Facebook</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="facebook" value="https://www.facebook.com/Dashlead">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Linked in</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="linkedin" value="linkedin.com/in/spruko">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 main-content-label">About Yourself</div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Biographical Info</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <textarea class="form-control" name="example-textarea-input" rows="4" placeholder="Please say something about yourself"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 main-content-label">Notifications</div>
                                        <div class="form-group mb-0">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Configure Notifications</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked="">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">Allow all Notifications</span>
                                                    </label>
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">Disable all Notifications</span>
                                                    </label>
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked="">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">Notification Sounds</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer py-3">
                                    <button class="btn ripple btn-success w-sm float-end">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab4account">
                            <div class="card">
                                <div class="card-body" data-select2-id="12">
                                    <form class="form-horizontal" data-select2-id="11">
                                        <div class="mb-4 main-content-label">Account</div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">User Name</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="User Name" value="Sonia Taylor"> </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Email</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="Email" value="klomitoor@doamin.com"> </div>
                                            </div>
                                        </div>
                                        <div class="form-group " data-select2-id="108">
                                            <div class="row" data-select2-id="107">
                                                <div class="col-md-2">
                                                    <label class="form-label">Language</label>
                                                </div>
                                                <div class="col-md-10" data-select2-id="106">
                                                    <select class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                        <option data-select2-id="31">UK English</option>
                                                        <option data-select2-id="109">Arabic</option>
                                                        <option data-select2-id="110">Korean</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group " data-select2-id="10">
                                            <div class="row" data-select2-id="9">
                                                <div class="col-md-2">
                                                    <label class="form-label">Timezone</label>
                                                </div>
                                                <div class="col-md-10" data-select2-id="8">
                                                    <select class="form-control select2" data-select2-id="4" tabindex="-1" aria-hidden="true">
                                                        <option value="Pacific/Midway" data-select2-id="6">(GMT-11:00) Midway Island, Samoa</option>
                                                        <option value="America/Adak" data-select2-id="16">(GMT-10:00) Hawaii-Aleutian</option>
                                                        <option value="Etc/GMT+10" data-select2-id="17">(GMT-10:00) Hawaii</option>
                                                        <option value="Pacific/Marquesas" data-select2-id="18">(GMT-09:30) Marquesas Islands</option>
                                                        <option value="Pacific/Gambier" data-select2-id="19">(GMT-09:00) Gambier Islands</option>
                                                        <option value="America/Anchorage" data-select2-id="20">(GMT-09:00) Alaska</option>
                                                        <option value="America/Ensenada" data-select2-id="21">(GMT-08:00) Tijuana, Baja California</option>
                                                        <option value="Etc/GMT+8" data-select2-id="22">(GMT-08:00) Pitcairn Islands</option>
                                                        <option value="America/Los_Angeles" data-select2-id="23">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                                                        <option value="America/Denver" data-select2-id="24">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                                                        <option value="America/Chihuahua" data-select2-id="25">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                                        <option value="America/Dawson_Creek" data-select2-id="26">(GMT-07:00) Arizona</option>
                                                        <option value="America/Belize" data-select2-id="27">(GMT-06:00) Saskatchewan, Central America</option>
                                                        <option value="America/Cancun" data-select2-id="28">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                                        <option value="Chile/EasterIsland" data-select2-id="29">(GMT-06:00) Easter Island</option>
                                                        <option value="America/Chicago" data-select2-id="30">(GMT-06:00) Central Time (US &amp; Canada)</option>
                                                        <option value="America/New_York" data-select2-id="31">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                                                        <option value="America/Havana" data-select2-id="32">(GMT-05:00) Cuba</option>
                                                        <option value="America/Bogota" data-select2-id="33">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                                        <option value="America/Caracas" data-select2-id="34">(GMT-04:30) Caracas</option>
                                                        <option value="America/Santiago" data-select2-id="35">(GMT-04:00) Santiago</option>
                                                        <option value="America/La_Paz" data-select2-id="36">(GMT-04:00) La Paz</option>
                                                        <option value="Atlantic/Stanley" data-select2-id="37">(GMT-04:00) Faukland Islands</option>
                                                        <option value="America/Campo_Grande" data-select2-id="38">(GMT-04:00) Brazil</option>
                                                        <option value="America/Goose_Bay" data-select2-id="39">(GMT-04:00) Atlantic Time (Goose Bay)</option>
                                                        <option value="America/Glace_Bay" data-select2-id="40">(GMT-04:00) Atlantic Time (Canada)</option>
                                                        <option value="America/St_Johns" data-select2-id="41">(GMT-03:30) Newfoundland</option>
                                                        <option value="America/Araguaina" data-select2-id="42">(GMT-03:00) UTC-3</option>
                                                        <option value="America/Montevideo" data-select2-id="43">(GMT-03:00) Montevideo</option>
                                                        <option value="America/Miquelon" data-select2-id="44">(GMT-03:00) Miquelon, St. Pierre</option>
                                                        <option value="America/Godthab" data-select2-id="45">(GMT-03:00) Greenland</option>
                                                        <option value="America/Argentina/Buenos_Aires" data-select2-id="46">(GMT-03:00) Buenos Aires</option>
                                                        <option value="America/Sao_Paulo" data-select2-id="47">(GMT-03:00) Brasilia</option>
                                                        <option value="America/Noronha" data-select2-id="48">(GMT-02:00) Mid-Atlantic</option>
                                                        <option value="Atlantic/Cape_Verde" data-select2-id="49">(GMT-01:00) Cape Verde Is.</option>
                                                        <option value="Atlantic/Azores" data-select2-id="50">(GMT-01:00) Azores</option>
                                                        <option value="Europe/Belfast" data-select2-id="51">(GMT) Greenwich Mean Time : Belfast</option>
                                                        <option value="Europe/Dublin" data-select2-id="52">(GMT) Greenwich Mean Time : Dublin</option>
                                                        <option value="Europe/Lisbon" data-select2-id="53">(GMT) Greenwich Mean Time : Lisbon</option>
                                                        <option value="Europe/London" data-select2-id="54">(GMT) Greenwich Mean Time : London</option>
                                                        <option value="Africa/Abidjan" data-select2-id="55">(GMT) Monrovia, Reykjavik</option>
                                                        <option value="Europe/Amsterdam" data-select2-id="56">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                                        <option value="Europe/Belgrade" data-select2-id="57">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                                        <option value="Europe/Brussels" data-select2-id="58">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                                        <option value="Africa/Algiers" data-select2-id="59">(GMT+01:00) West Central Africa</option>
                                                        <option value="Africa/Windhoek" data-select2-id="60">(GMT+01:00) Windhoek</option>
                                                        <option value="Asia/Beirut" data-select2-id="61">(GMT+02:00) Beirut</option>
                                                        <option value="Africa/Cairo" data-select2-id="62">(GMT+02:00) Cairo</option>
                                                        <option value="Asia/Gaza" data-select2-id="63">(GMT+02:00) Gaza</option>
                                                        <option value="Africa/Blantyre" data-select2-id="64">(GMT+02:00) Harare, Pretoria</option>
                                                        <option value="Asia/Jerusalem" data-select2-id="65">(GMT+02:00) Jerusalem</option>
                                                        <option value="Europe/Minsk" data-select2-id="66">(GMT+02:00) Minsk</option>
                                                        <option value="Asia/Damascus" data-select2-id="67">(GMT+02:00) Syria</option>
                                                        <option value="Europe/Moscow" data-select2-id="68">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                                        <option value="Africa/Addis_Ababa" data-select2-id="69">(GMT+03:00) Nairobi</option>
                                                        <option value="Asia/Tehran" data-select2-id="70">(GMT+03:30) Tehran</option>
                                                        <option value="Asia/Dubai" data-select2-id="71">(GMT+04:00) Abu Dhabi, Muscat</option>
                                                        <option value="Asia/Yerevan" data-select2-id="72">(GMT+04:00) Yerevan</option>
                                                        <option value="Asia/Kabul" data-select2-id="73">(GMT+04:30) Kabul</option>
                                                        <option value="Asia/Yekaterinburg" data-select2-id="74">(GMT+05:00) Ekaterinburg</option>
                                                        <option value="Asia/Tashkent" data-select2-id="75">(GMT+05:00) Tashkent</option>
                                                        <option value="Asia/Kolkata" data-select2-id="76">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                                        <option value="Asia/Katmandu" data-select2-id="77">(GMT+05:45) Kathmandu</option>
                                                        <option value="Asia/Dhaka" data-select2-id="78">(GMT+06:00) Astana, Dhaka</option>
                                                        <option value="Asia/Novosibirsk" data-select2-id="79">(GMT+06:00) Novosibirsk</option>
                                                        <option value="Asia/Rangoon" data-select2-id="80">(GMT+06:30) Yangon (Rangoon)</option>
                                                        <option value="Asia/Bangkok" data-select2-id="81">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                                        <option value="Asia/Krasnoyarsk" data-select2-id="82">(GMT+07:00) Krasnoyarsk</option>
                                                        <option value="Asia/Hong_Kong" data-select2-id="83">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                                        <option value="Asia/Irkutsk" data-select2-id="84">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                                        <option value="Australia/Perth" data-select2-id="85">(GMT+08:00) Perth</option>
                                                        <option value="Australia/Eucla" data-select2-id="86">(GMT+08:45) Eucla</option>
                                                        <option value="Asia/Tokyo" data-select2-id="87">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                                        <option value="Asia/Seoul" data-select2-id="88">(GMT+09:00) Seoul</option>
                                                        <option value="Asia/Yakutsk" data-select2-id="89">(GMT+09:00) Yakutsk</option>
                                                        <option value="Australia/Adelaide" data-select2-id="90">(GMT+09:30) Adelaide</option>
                                                        <option value="Australia/Darwin" data-select2-id="91">(GMT+09:30) Darwin</option>
                                                        <option value="Australia/Brisbane" data-select2-id="92">(GMT+10:00) Brisbane</option>
                                                        <option value="Australia/Hobart" data-select2-id="93">(GMT+10:00) Hobart</option>
                                                        <option value="Asia/Vladivostok" data-select2-id="94">(GMT+10:00) Vladivostok</option>
                                                        <option value="Australia/Lord_Howe" data-select2-id="95">(GMT+10:30) Lord Howe Island</option>
                                                        <option value="Etc/GMT-11" data-select2-id="96">(GMT+11:00) Solomon Is., New Caledonia</option>
                                                        <option value="Asia/Magadan" data-select2-id="97">(GMT+11:00) Magadan</option>
                                                        <option value="Pacific/Norfolk" data-select2-id="98">(GMT+11:30) Norfolk Island</option>
                                                        <option value="Asia/Anadyr" data-select2-id="99">(GMT+12:00) Anadyr, Kamchatka</option>
                                                        <option value="Pacific/Auckland" data-select2-id="100">(GMT+12:00) Auckland, Wellington</option>
                                                        <option value="Etc/GMT-12" data-select2-id="101">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                                        <option value="Pacific/Chatham" data-select2-id="102">(GMT+12:45) Chatham Islands</option>
                                                        <option value="Pacific/Tongatapu" data-select2-id="103">(GMT+13:00) Nuku'alofa</option>
                                                        <option value="Pacific/Kiritimati" data-select2-id="104">(GMT+14:00) Kiritimati</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Verification</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked="">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">SMS</span>
                                                    </label>
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked="">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">Email ID</span>
                                                    </label>
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked="">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">Phone</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 main-content-label">Secuirity Settings</div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Change Password</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="password" class="form-control" placeholder="Enter New Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Confirm Password</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="password" class="form-control" placeholder="Confirm Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="form-label">Account Security</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked="">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">Always Logged In</span>
                                                    </label>
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked="">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">Save Passwords</span>
                                                    </label>
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">Display Info on your Profile</span>
                                                    </label>
                                                    <label class="custom-switch d-block mg-b-15-f">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked="">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="text-muted ms-2">Two Factor Authentication</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer py-3">
                                    <div class="btn-list float-end">
                                        <button class="btn ripple btn-outline-primary w-md">Delete Account</button>
                                        <button class="btn ripple btn-primary w-md">Deactivate Account</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

            <!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="card-header border-bottom-0 p-0">
                    <h6 class="card-title mb-1">Users Schedule</h6>
                    <p class="text-muted card-sub-title">All users schedules can be found here</p>
                </div>
                <div class="table-responsive">
                    <table class="table" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-20p">Type</th>
                                <th class="wd-25p">Location</th>
                                <th class="wd-20p">Status</th>
                                <th class="wd-15p">Start Date</th>
                                <th class="wd-20p">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedules as $schedule)
                            <tr>
                                <td>{{$schedule->exercise_type ?? 'Not available'}}</td>
                                <td>{{$schedule->location_name ?? 'Not available'}}</td>
                                @if ($schedule->schedule_status == 1)
                                <td class="text-primary">Active</td>
                                @else
                                <td class="text-secondary">Ended</td>
                                @endif

                                <td>{{ Carbon\Carbon::parse($schedule->start_date)->diffForHumans() ?? 'Not available' }}</td>
                                <td class="text-primary" style="display:flex; gap:2px;">
                                    <a class="btn ripple btn-primary" href="{{route('user.schedule', $schedule->id)}}"><i class="fe fe-eye"></i></a>
                                    <a class="btn ripple btn-secondary" href="javascript:void(0);"><i class="fe fe-edit"></i></a>
                                    <a class="btn ripple btn-danger" href="javascript:void(0);"><i class="fe fe-trash"></i></a>
                                </td>

                            </tr>

                            @empty
                            <tr>
                                No Schedule
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

