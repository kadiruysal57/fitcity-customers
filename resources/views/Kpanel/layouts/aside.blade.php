<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{route('dashboard')}}" class="header-logo">
            <img src="{{asset('/nowa-panel/assets/images/logo.png')}}" alt="logo" class="desktop-logo">
            <img src="{{asset('/nowa-panel/assets/images/fitcity-favicon.png')}}" alt="logo" class="toggle-logo">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->


                <!-- Start::slide -->
                <li class="slide ">
                    <a href="{{route('kpanel')}}"
                       class="side-menu__item @if(Route::currentRouteName() == "dashboard") active @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24"
                             viewBox="0 0 24 24">
                            <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/>
                        </svg>
                        <span class="side-menu__label">Dashboards</span>
                    </a>
                </li>
                <!-- End::slide -->

                <li class="slide__category"><span class="category-name">Hesap</span></li>


                <!-- Start::slide -->
                <li class="slide ">
                    <a href="{{route('PersonelInformation')}}"
                       class="side-menu__item @if(Route::currentRouteName() == "PersonelInformation") active @endif">
                        <i class="fa fa-id-card"></i>
                        <span class="side-menu__label"
                              style="margin-left: 5px;font-size: 12px;">Kişisel Bilgilerim </span>
                    </a>
                </li>
                <li class="slide ">
                    <a href="{{route('Measurements')}}"
                       class="side-menu__item @if(Route::currentRouteName() == "Measurements") active @endif">
                        <i class="fa fa-balance-scale"></i>
                        <span class="side-menu__label" style="margin-left: 5px;font-size: 12px;">Ölçümlerim</span>
                    </a>
                </li>

                <li class="slide__category"><span class="category-name">Ödemelerim</span></li>
                <li class="slide ">
                    <a href="{{route('CreditCardList')}}"
                       class="side-menu__item @if(Route::currentRouteName() == "CreditCardList") active @endif">
                        <i class="fa fa-credit-card"></i>
                        <span class="side-menu__label"
                              style="margin-left: 5px;font-size: 12px;">Kayıtlı Kartlarım </span>
                    </a>
                </li>
                <li class="slide ">
                    <a href="{{route('MembershipInformation')}}"
                       class="side-menu__item @if(Route::currentRouteName() == "MembershipInformation") active @endif">
                        <i class="fa fa-object-group"></i>
                        <span class="side-menu__label"
                              style="margin-left: 5px;font-size: 12px;">Üyelik Bilgilerim </span>
                    </a>
                </li>
                <li class="slide ">
                    <a href="{{route('Orders')}}"
                       class="side-menu__item @if(Route::currentRouteName() == "Orders") active @endif">
                        <i class="fa-solid fa-list"></i>
                        <span class="side-menu__label" style="margin-left: 5px;font-size: 12px;">Siparişlerim </span>
                    </a>
                </li>
                <li class="slide__category"><span class="category-name">Ürünler</span></li>

                <li class="slide ">
                    <a href="{{route('ProductsList')}}"
                       class="side-menu__item @if(Route::currentRouteName() == "ProductsList") active @endif">
                        <i class="fa-solid fa-gift"></i>
                        <span class="side-menu__label" style="margin-left: 5px;font-size: 12px;">Ürünlerimiz </span>
                    </a>
                </li>
                <li class="slide ">
                    <a href="{{route('BasketList')}}"
                       class="side-menu__item @if(Route::currentRouteName() == "BasketList") active @endif">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <span class="side-menu__label" style="margin-left: 5px;font-size: 12px;">Sepet </span>
                    </a>
                </li>


            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
