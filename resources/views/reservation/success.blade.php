@extends('layouts.adminlte')

@section('extra-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection
@section('extra-js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection

@section('title', 'Client - Dashboard')
@section('navbar')
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
        </ul>
    </nav>
    <!-- /.navbar -->
@endsection
@section('sidebar')
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/home" class="brand-link">
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Client - Dashboard</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar mb-3 mt-2">
            <!-- Sidebar user panel (optional) -->
            @if (Auth::guard('client')->check())
                <div class="image">
                    <img style="width:60px; height:60px; object-fit:center;"
                        src="{{ asset(Auth::guard('client')->user()->avatar) }}" class="img-circle elevation-2"
                        alt="User Image">
                </div>
                <div class="info mt-2">
                    <a href="#" class="d-block">{{ Auth::guard('client')->user()->name }}</a>
                </div>
            @else
                <div class="image">
                    <img style="width:60px; height:60px; object-fit:center;"
                        src="{{ asset('avatars/clients/clients_default_avatar.png') }}" class="img-circle elevation-2"
                        alt="User Image">
                </div>
                <div class="info mt-2">
                    <a href="#" class="d-block">Guest</a>
                </div>
            @endif
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul style="position:relative; min-height: 75vh;" class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="/rooms" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Rooms
                        </p>
                    </a>
                </li>
                @if (Auth::guard('client')->check())
                    <li class="nav-item has-treeview">
                        <a href="/client/reservations" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                My Reservations
                            </p>
                        </a>
                    </li>
                @endif
                @if (Auth::guard('client')->check())
                    <li style="cursor:pointer; bottom:10px; margin-top:auto; width:100%;" class="nav-item has-treeview">
                        <form action="{{ route('client.logout') }}" method="POST">
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
                @else
                    <li style="cursor:pointer; bottom:10px; margin-top:auto; width:100%;" class="nav-item has-treeview">
                        <a href="/client/login" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Login
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

@endsection
@section('content')
    <div class="content-wrapper pt-4">
        @if (session('success'))
            <div class="container">
                <div class="w-50 alert alert-success mx-auto mb-4">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- /.home -->
        @if (isset($user))
            <div class="mx-auto card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <h6 style="margin-top:22px;" class="card-subtitle mb-2 text-muted">Client</h6>
                    <p class="card-text">{{ $user->email }}</p>
                </div>
            </div>
        @endif

    </div>

@endsection
