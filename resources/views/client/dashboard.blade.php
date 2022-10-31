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
        <a href="index3.html" class="brand-link">
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
                <li class="nav-header" style="margin-top:auto;">SETTINGS</li>
                @if (Auth::guard('client')->check())
                    @if (!Auth::guard('client')->user()->hasVerifiedEmail())
                        <li style="cursor:pointer; bottom:10px; width:100%;" class="nav-item has-treeview">
                            <a href="{{ route('verification.fire') }}" class="nav-link">
                                <i class="nav-icon fas fa-check"></i>
                                <p>
                                    Verify Email
                                </p>
                            </a>
                        </li>
                    @endif
                    <li style="cursor:pointer; bottom:10px; width:100%;" class="nav-item has-treeview">
                        <a href="{{ route('clients.edit', Auth::guard('client')->user()->id) }}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Edit Profile
                            </p>
                        </a>
                    </li>
                    <li style="cursor:pointer; bottom:10px; width:100%;" class="nav-item has-treeview">
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
                    <li style="cursor:pointer; bottom:10px; width:100%;" class="nav-item has-treeview">
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
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            </div>
        @elseif (session('fail'))
            <div class="container">
                <div class="alert alert-danger mb-4">
                    {{ session('fail') }}
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


        <!-- /.rooms -->
        @if (isset($rooms))
            <div class="container">
                @if (!empty($rooms))
                    <x-data-table>
                        <x-slot name="thead">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        #
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example" rowspan="1"
                                        colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Number
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Floor Name
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Capacity
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Price
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                        </x-slot>
                        <x-slot name="tbody">
                            <tbody>
                                @foreach ($rooms as $room)
                                    <tr class="{{ $loop->index % 2 === 0 ? 'odd' : 'even' }}">
                                        <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                                        <td class="dtr-control sorting_1" tabindex="1">{{ $room->number }}</td>
                                        <td>{{ $room->floor->name }}</td>
                                        <td>{{ $room->capacity }}</td>
                                        <td>{{ $room->price }}</td>
                                        <td
                                            class="dt-body-right dtr-hidden d-md-flex align-items-center justify-content-start">
                                            <a href="{{ route('reservations.create', $room->id) }}"
                                                style="width:fit-content;" type="button"
                                                class="mr-1 btn btn-block m-0 btn-info btn-xs">Make Reservation</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </x-slot>
                        <x-slot name="tfoot">
                            <tfoot>
                                <tr>
                                    <th class="font-weight-bold" rowspan="1" colspan="1">#</th>
                                    <th rowspan="1" colspan="1">Number</th>
                                    <th rowspan="1" colspan="1">Floor Name</th>
                                    <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                        Capacity
                                    </th>
                                    <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                        Price
                                    </th>
                                    <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                        Actions
                                    </th>
                                </tr>
                            </tfoot>
                        </x-slot>
                    </x-data-table>
                @endif
            </div>
        @endif


        <!-- /.reservations -->
        @if (isset($reservations))
            <div class="container">

                @if (!empty($reservations))
                    <x-data-table>
                        <x-slot name="thead">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold sorting sorting_asc" tabindex="0"
                                        aria-controls="example" rowspan="1" colspan="1" style="width: 105px"
                                        aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                        #
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Client
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Room Number
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Floor Number
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Duration
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Price Paid Per Day
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Accompany Number
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        Start Date
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                        rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">
                                        End Date
                                    </th>
                                </tr>
                            </thead>
                        </x-slot>
                        <x-slot name="tbody">
                            <tbody>
                                @foreach ($reservations as $reservation)
                                    <tr class="{{ $loop->index % 2 === 0 ? 'odd' : 'even' }}">
                                        <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                                        <td class="dtr-control sorting_1" tabindex="1">
                                            {{ $reservation->client->name }}</td>
                                        <td>{{ $reservation->room_number }}</td>
                                        <td>{{ $reservation->floor->name }}</td>
                                        <td>{{ $reservation->duration }}</td>
                                        <td>{{ $reservation->price_paid_per_day }}</td>
                                        <td>{{ $reservation->accompany_number }}</td>
                                        <td>{{ $reservation->getStDate() }}</td>
                                        <td>{{ $reservation->getEndDate() }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </x-slot>
                        <x-slot name="tfoot">
                            <tfoot>
                                <tr>
                                    <th class="font-weight-bold" rowspan="1" colspan="1">#</th>
                                    <th rowspan="1" colspan="1">Client</th>
                                    <th rowspan="1" colspan="1">Room Number</th>
                                    <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                        Floor Number
                                    </th>
                                    <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                        Duration
                                    </th>
                                    <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                        Price Paid Per Day
                                    </th>
                                    <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                        Accompany Number
                                    </th>
                                    <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                        Start Date
                                    </th>
                                    <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                        End Date
                                    </th>
                                </tr>
                            </tfoot>
                        </x-slot>
                    </x-data-table>
                @endif
            </div>

        @endif

    </div>

@endsection
