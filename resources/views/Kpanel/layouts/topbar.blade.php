<header class="app-header">

    <div class="main-header-container container-fluid">

        <div class="header-content-left align-items-center">
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                <!-- End::header-link -->
            </div>


        </div>

        <div class="header-content-right">

            <div class="header-element header-fullscreen">
                <a onclick="openFullscreen();" href="#" class="header-link">
                    <i class="bx bx-fullscreen full-screen-open header-link-icon"></i>
                    <i class="bx bx-exit-fullscreen full-screen-close header-link-icon d-none"></i>
                </a>
            </div>

            <div class="header-element header-basket">
                <a href="{{route('BasketList')}}" class="header-link">
                    <i class="fa fa-basket-shopping"></i>
                </a>
            </div>


            <div class="header-element">
                <a href="#" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown"
                   data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                            @php
                            $image = 'panel/assets/img/avatar/9.png';
                            if(!empty(\Illuminate\Support\Facades\Auth::user()->image)){
                                $image = "https://api.fitcity.com.tr/storage/profile_photos/42/1MurbVmOlwgoElR9IQSlx6uWaYrRBMPPxl6emOdO.jpg";
                            }
                            @endphp
                            <img src="{{asset($image)}}" alt="img" width="32" height="32"
                                 class="rounded-circle">

                        </div>
                        <div class="d-xl-block d-none">
                            <p class="fw-semibold mb-0 lh-1">{{Auth()->user()->name}}</p>
                        </div>
                    </div>
                </a>
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">
                    <li><a class="dropdown-item d-flex" href="{{route('logout')}}"><i
                                    class="far fa-arrow-alt-circle-left fs-16 me-2 op-7"></i>Sign Out</a></li>
                </ul>
            </div>


        </div>

    </div>

</header>
