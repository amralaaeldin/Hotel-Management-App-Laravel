@extends('layouts.adminlte')


@section('title')
    Show - @yield('name')
@endsection


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
                <img src="{{ asset(Auth::guard('web')->user()->avatar) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::guard('web')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                                                                                                                                                                                                                                                                                                                           with font-awesome or any other icon font library -->
                <li class="nav-header">staff</li>
                @can('view managers', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/admin/managers" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Managers
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view receptionists', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/admin/receptionists" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Receptionists
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view clients', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/admin/clients" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Clients
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-header">HOTEL</li>
                @can('view floors', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/admin/floors" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Floors
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view rooms', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/admin/rooms" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Rooms
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view reservations', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/admin/reservations" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Client Reservations
                            </p>
                        </a>
                    </li>
                @endcan

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@endsection

@section('content')
    <div class="content-wrapper d-flex align-items-center justify-content-center">
        <div class="card pt-4" style="width: 18rem;">
            <img style="width:216px; object-fit:center; height:216px; border-radius:50%"
                class="w-75 mx-auto rounded-circle shadow" src="@yield('avatar-src')" alt="@yield('avatar-alt')">

            <div class="card-body pb-1">
                <h1 class="font-weight-bold card-title">@yield('username')</h1>
                <p class="text-muted card-text">@yield('role')</p>
            </div>
            <ul class="list-group d-flex list-group-flush">
                @yield('list-items')
            </ul>
            <div class="card-body d-flex align-items-center justify-content-around">
                <a href="#" class="btn btn-outline-primary card-link">Back</a>
                <a href="@yield('edit')" class="btn btn-outline-info card-link">Edit</a>
                <a href="@yield('delete')" class="btn btn-outline-danger card-link">Delete</a>
            </div>
        </div>
    </div>
@endsection
