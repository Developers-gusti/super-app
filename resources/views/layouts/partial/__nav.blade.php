<!--begin::Aside-->
<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('dashboard') }}">
            <img alt="Logo" src="{{ asset('build/assets/media/logos/logo-1-dark.svg') }}" class="h-25px logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <i class="bi bi-chevron-double-left " style="font-size: 1.3rem;" fill="currentColor"></i>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : ''  }}" href="{{ route('dashboard') }}">
                        <span class="menu-icon"><i class="bi bi-display" style="font-size: 1.5rem;"></i></span>
                        <span class="menu-title">{{ __('label.dashboard') }}</span>
                    </a>
                </div>
                @can('menu_setting')
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('settings*') ? 'here show' : ''  }} menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon"> <i class="bi bi-gear" style="font-size: 1.5rem;"></i></span>
                        <span class="menu-title">{{ __('label.menu.settings') }}</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @can('read_user')
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('settings.user*') ? 'active' : ''  }}" href="{{ route('settings.user') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __('label.menu.user') }}</span>
                            </a>
                        </div>
                        @endcan
                        @can('read_role')
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('role') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __('label.menu.role') }}</span>
                            </a>
                        </div>
                        @endcan
                        @can('read_permission')
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('settings.permission*') ? 'active' : ''  }}" href="{{route('settings.permission')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __('label.menu.permission') }}</span>
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
                @endcan
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
</div>
<!--end::Aside-->

