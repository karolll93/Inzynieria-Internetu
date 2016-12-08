@extends('dashboard/layout')

@section('left')

    <div class="float-xs-right"><a href="{{ route("dashboard.leagues") }}" class="btn btn-primary btn-sm">powrót</a></div>

    <h3>Panel administracyjny<small> &raquo; przynależność klubów do rozgrywki</small></h3>

    <p>Rozgrywka: <strong>{{ $league->roz_liga }} - {{ $league->roz_nazwa }} (sezon {{ $league->roz_sezon }})</strong></p>

    @if ($message)
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if (count($clubs_canAdd) > 0)
        <div class="text-xs-center mb-1"><a href="#" data-toggle="collapse" data-target="#form_add_club" class="btn btn-success btn-sm">dodaj klub</a></div>
        <form action="{{ route("dashboard.leagues.clubs", ["id"=>$league->roz_id]) }}" method="post" id="form_add_club" class="collapse form-inline text-xs-center mb-1">
            {{ csrf_field() }}
            <select class="form-control" name="club">
                @foreach ($clubs_canAdd as $c)
                    <option value="{{ $c->k_id }}">{{ $c->k_nazwa }}</option>
                @endforeach
            </select>
            <input type="submit" class="btn btn-success" value="dodaj" />
        </form>
    @endif

    @if(count($clubs) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Klub</th>
                        <th class="text-xs-center">Zarządzaj</th>
                        <th colspan="2" class="text-xs-center">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clubs as $c)
                        <tr>
                            <td>{{ $c->k_nazwa }}</td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.leagues.clubs.players", ['id'=>$league->roz_id, 'club_id'=>$c->k_id]) }}" class="btn btn-primary btn-sm">zawodnicy ({{ $players_count[$c->k_id] }})</a></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.leagues.clubs.delete", ['id'=>$league->roz_id,'club_id'=>$c->k_id]) }}" class="btn btn-danger btn-sm" data-toggle="confirm" title="Na pewno chcesz usunąć ten klub z tej rozgrywki?!">usuń z rozgrywki</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">brak klubów</div>
    @endif

@endsection