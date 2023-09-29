@php
    $prefix = Auth::guard('web')
        ->user()
        ->getRoleNames()[0];
    if (in_array($prefix, ['manager', 'receptionist'])) {
        $prefix = 'staff';
    }
@endphp

@extends('layouts.adminlte')



@section('sidebar')
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/home" class="brand-link">
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">Admin - Dashboard</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="image">
                <img style="width:60px; height:60px; object-fit:center;"
                    src="{{ asset(Auth::guard('web')->user()->avatar) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::guard('web')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul style="position:relative; min-height: 75vh;" class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-header">Staff</li>
                @can('view managers', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ Auth::guard('web')->user()->getRoleNames()[0] }}/managers" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Managers
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view receptionists', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ Auth::guard('web')->user()->getRoleNames()[0] }}/receptionists" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Receptionists
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view clients', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ Auth::guard('web')->user()->getRoleNames()[0] }}/clients" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Clients
                            </p>
                        </a>
                    </li>
                @endcan
                @role('receptionist', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ Auth::guard('web')->user()->getRoleNames()[0] }}/my-clients" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                My Clients
                            </p>
                        </a>
                    </li>
                @endrole
                <li class="nav-header">HOTEL</li>
                @can('view floors', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ Auth::guard('web')->user()->getRoleNames()[0] }}/floors" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Floors
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view rooms', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ Auth::guard('web')->user()->getRoleNames()[0] }}/rooms" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Rooms
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view reservations', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ Auth::guard('web')->user()->getRoleNames()[0] }}/reservations" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Client Reservations
                            </p>
                        </a>
                    </li>
                @endcan
                @if ($prefix != 'admin')
                    <li style="cursor:pointer; margin-top:auto; bottom:10px; width:100%;" class="nav-item has-treeview">
                        <a href="{{ route(Auth::guard('web')->user()->getRoleNames()[0] .'s' .'.edit',Auth::guard('web')->user()->id) }}"
                            class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Edit Profile
                            </p>
                        </a>
                    </li>
                @endif
                <li style="cursor:pointer; @if ($prefix === 'admin') margin-top:auto; @endif bottom:10px;  width:100%;"
                    class="nav-item has-treeview">
                    <form action="{{ route($prefix . '.logout') }}" method="POST">
                        @csrf
                        <button class="nav-link" onmouseout="this.style.color='#6c757d'"
                            onmouseover="this.style.color='#fff'"
                            style="width:100%; text-align:left; border:none; outline:none; background:transparent; color:#6c757d;"
                            type="submit">
                            <i class="nav-icon fas fa-cog"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@endsection

@section('content')
    <div class="content-wrapper d-flex align-items-center justify-content-center">
        <div class="w-50 card card-info">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" @yield('form-attributes') action="@yield('route')">
                @csrf
                <div class="card-body">
                    @yield('fields')
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">@yield('submit-word')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
