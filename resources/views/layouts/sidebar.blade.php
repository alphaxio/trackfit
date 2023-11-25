<div class="sticky">
    <aside class="app-sidebar ps horizontal-main">
        <div class="app-sidebar__header">
            <a class="main-logo" href="{{route('home')}}">
                <img src="/assets/img/brand/logo.png" class="desktop-logo desktop-logo-dark" alt="dashleadlogo">
                <img src="/assets/img/brand/logo1.png" class="desktop-logo" alt="dashleadlogo">
                <img src="/assets/img/brand/favicon.png" class="mobile-logo mobile-logo-dark" alt="dashleadlogo">
                <img src="/assets/img/brand/favicon1.png" class="mobile-logo" alt="dashleadlogo">
            </a>
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="side-menu">
                <li class="side-item side-item-category">Dashboard</li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{route('home')}}">
                        <span class="side-menu__icon">
                            <i class="fe fe-airplay side_menu_img"></i>
                        </span>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="side-item side-item-category">Menu</li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <span class="side-menu__icon"><i class="fe fe-users side_menu_img"></i></span>
                        <span class="side-menu__label">Users</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <ul class="sidemenu-list">
                                <li class="side-menu__label1"><a href="javascript:void(0)">Apps</a></li>
                                <li><a href="{{route('users')}}" class="slide-item">All users</a></li>
                                {{-- <li><a href="cards.html" class="slide-item">Cards</a></li>
                                <li><a href="treeview.html" class="slide-item">Treeview</a></li>
                                <li><a href="switcher.html" class="slide-item">Switcher</a></li> --}}
                            </ul>
                        </li>
                    </ul>
                </li>
                {{-- <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <span class="side-menu__icon"><i class="fe fe-award side_menu_img"></i></span>
                        <span class="side-menu__label">Icons</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <ul class="sidemenu-list">
                                <li class="side-menu__label1"><a href="javascript:void(0)">Icons</a></li>
                                <li><a href="icons.html" class="slide-item">Fontawesome Icons</a></li>
                                <li><a href="icons-2.html" class="slide-item">Ionicons Icons</a></li>
                                <li><a href="typ-icons.html" class="slide-item">Typicon Icons</a></li>
                                <li><a href="feather-icons.html" class="slide-item">Feather Icons</a></li>
                                <li><a href="material-icons.html" class="slide-item">MaterialDesign Icons</a></li>
                                <li><a href="simple-icons.html" class="slide-item">Simpleline Icons</a></li>
                                <li><a href="pe7-icons.html" class="slide-item">Pe7 Icons</a></li>
                                <li><a href="themify-icons.html" class="slide-item">Themify Icons</a></li>
                                <li><a href="weather-icons.html" class="slide-item">Weather Icons</a></li>
                                <li><a href="bootstrap-icons.html" class="slide-item">Bootstrap Icons</a></li>
                                <li><a href="flags-icons.html" class="slide-item">Flag Icons</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                        <span class="side-menu__icon"><i class="fe fe-map-pin side_menu_img"></i></span>
                        <span class="side-menu__label">Maps</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <ul class="sidemenu-list">
                                <li class="side-menu__label1"><a href="javascript:void(0)">Maps</a></li>
                                <li><a href="map-mapel.html" class="slide-item">Mapel Maps</a></li>
                                <li><a href="map-vector.html" class="slide-item">Vector Maps</a></li>
                                <li><a href="map-leaflet.html" class="slide-item">Leaflet Maps</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="landing.html">
                        <span class="side-menu__icon">
                            <i class="fe fe-zap side_menu_img"></i>
                        </span>
                        <span class="side-menu__label">Landing Page</span><span class="badge badge-sm bg-success ms-2">New</span>
                    </a>
                </li> --}}
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </div>
    </aside>
</div>
