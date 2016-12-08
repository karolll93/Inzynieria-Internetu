@extends('layout')

@section('content')

    <h3>Logowanie</h3>
    <form action="{{ route("login") }}" method="post">
        {{ csrf_field() }}
        @if ($error)
            <div class="alert alert-danger">{{ $error  }}</div>
        @endif
        <div class="form-group row">
            <label for="fl_username" class="col-xs-2 offset-md-2 col-md-2 col-form-label">Nazwa użytkownika:</label>
            <div class="col-xs-10 col-md-6">
                <input class="form-control" name="username" type="text" placeholder="nazwa użytkownika" id="fl_username" maxlength="32" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="fl_password" class="col-xs-2 offset-md-2 col-md-2 col-form-label">Hasło:</label>
            <div class="col-xs-10 col-md-6">
                <input class="form-control" name="password" type="password" placeholder="hasło" id="fl_password" maxlength="32" required />
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-xs-2 col-xs-10 offset-md-4 col-md-6">
                <input type="hidden" name="redirect" value="{{ $redirect }}" />
                <input type="submit" name="log_in" value="zaloguj się" class="btn btn-success btn-block"/>
            </div>
        </div>
    </form>

@endsection