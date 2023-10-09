<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link">
        <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
{{--        <div class="user-panel mt-3 pb-3 mb-3 d-flex">--}}
{{--            --}}{{--            @if (\Illuminate\Support\Facades\Auth::user()->profilePicturePath)--}}
{{--            <div class="image">--}}
{{--                <img src="{{ !empty($user->profilePicturePath) ? asset('images/profil/' . $user->profilePicturePath) : asset('images/profil/user_img.jpg') }}" class="img-circle elevation-2" alt="{{ trans('messages.user_image') }}">--}}
{{--            </div>--}}
{{--            --}}{{--            @endif--}}
{{--            <div class="info">--}}
{{--                <a href="{{ route('user.profile', Auth::id()) }}" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->email }}</a>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2" id="sidebar">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>

</aside>
