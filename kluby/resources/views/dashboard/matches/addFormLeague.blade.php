@extends('dashboard/layout')

@section('left')

    <h3>Dodaj mecz<small> &raquo; wybierz rozgrywkę</small></h3>
    <form action="{{ $url }}" method="post">
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="offset-md-3 col-md-6">
                <select class="form-control" id="iae_league_id" name="league_id">
                    @foreach ($leagues as $l)
                        <option value="{{ $l->roz_id }}">{{ $l->roz_nazwa }} - {{ $l->roz_liga }}  (sezon {{ $l->roz_sezon }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-md-3 col-md-6">
                <input type="submit" name="next" value="dalej" class="btn btn-success" />
                <div class="float-xs-right"><a href="{{ route("dashboard.matches") }}" class="btn btn-primary">powrót</a></div>
            </div>
        </div>
    </form>

@endsection