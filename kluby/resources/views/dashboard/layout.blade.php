@extends('layout')

@section('content')

    <div class="row">

        <div class="col-sm-9">
            <div id="left">
                @yield('left')
            </div>
        </div>

        <div class="col-sm-3">
            <div id="right">
                <h4>Panel administracyjny - Menu</h4>
                <div class="list-group">
                    <a href="{{ route("dashboard") }}" class="list-group-item">strona główna</a>
                    <a href="{{ route("dashboard.clubs") }}" class="list-group-item">kluby</a>
                    <a href="{{ route("dashboard.countries") }}" class="list-group-item">państwa</a>
                    <a href="{{ route("dashboard.players") }}" class="list-group-item">zawodnicy</a>
                </div>
            </div>
        </div>

    </div>

@endsection