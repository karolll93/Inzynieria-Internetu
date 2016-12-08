@extends('layout')

@section('content')

    <h3>Panel administracyjny</h3>

    <div class="row">
        <div class="col-sm-3">
            <div class="anchor-card card card-inverse card-info text-xs-center">
                <div class="card-block">
                    <a href="{{ route("dashboard.leagues") }}">zarządzaj rozgrywkami</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="anchor-card card card-inverse card-success text-xs-center">
                <div class="card-block">
                    <a href="{{ route("dashboard.clubs") }}">zarządzaj klubami</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="anchor-card card card-inverse card-primary text-xs-center">
                <div class="card-block">
                    <a href="{{ route("dashboard.countries") }}">zarządzaj państwami</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="anchor-card card card-inverse card-warning text-xs-center">
                <div class="card-block">
                    <a href="{{ route("dashboard.players") }}">zarządzaj zawodnikami</a>
                </div>
            </div>
        </div>
    </div>

@endsection