@extends('dashboard/layout')

@section('left')

    <h3>{{ $title }}</h3>
    <form action="{{ $url }}" method="post">
        {{ csrf_field() }}
        @if ($errors)
            <div class="alert alert-danger">
                @foreach($errors as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif
        @if ($message)
            <div class="alert alert-success">{{ $message }}</div>
        @endif
        <div class="form-group row">
            <label for="iae_league_name" class="offset-md-2 col-md-2 col-form-label">Liga<span class="required">*</span>:</label>
            <div class="col-md-6">
                <input class="form-control" name="league_name" value="{{ $league_name }}" type="text" placeholder="liga" id="iae_league_name" maxlength="50" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_type" class="offset-md-2 col-md-2 col-form-label">Typ<span class="required">*</span>:</label>
            <div class="col-md-6">
                <input class="form-control" name="type" value="{{ $type }}" type="text" placeholder="typ" id="iae_type" maxlength="20" required />
                <div>np. <strong>liga</strong>, <strong>grupa</strong></div>
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_name" class="offset-md-2 col-md-2 col-form-label">Nazwa<span class="required">*</span>:</label>
            <div class="col-md-6">
                <input class="form-control" name="name" value="{{ $name }}" type="text" placeholder="nazwa" id="iae_name" maxlength="100" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_season" class="offset-md-2 col-md-2 col-form-label">Sezon<span class="required">*</span>:</label>
            <div class="col-md-6">
                <input class="form-control" name="season" value="{{ $season }}" type="text" placeholder="sezon" id="iae_season" maxlength="9" required />
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-md-4 col-md-6">
                <input type="submit" name="save" value="{{ $mode }}" class="btn btn-success" />
                <div class="float-xs-right"><a href="{{ route("dashboard.leagues") }}" class="btn btn-primary">powrót</a></div>
            </div>
        </div>
    </form>

@endsection