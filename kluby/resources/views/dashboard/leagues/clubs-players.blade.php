@extends('dashboard/layout')

@section('left')

    <div class="float-xs-right"><a href="{{ route("dashboard.leagues.clubs", ['id'=>$league->roz_id]) }}" class="btn btn-primary btn-sm">powrót</a></div>

    <h3>Panel administracyjny<small> &raquo; przynależność zawodników do klubu</small></h3>

    <p>Rozgrywka: <strong>{{ $league->roz_liga }} - {{ $league->roz_nazwa }} (sezon {{ $league->roz_sezon }})</strong></p>
    <p>Klub: <strong>{{ $club->k_nazwa }}</strong></p>

    @if ($message)
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if (count($players_canAdd) > 0)
        <div class="text-xs-center mb-1"><a href="#" data-toggle="collapse" data-target="#form_add_player" class="btn btn-success btn-sm">dodaj zawodnika</a></div>
        <form action="{{ route("dashboard.leagues.clubs.players", ["id"=>$league->roz_id,"club_id"=>$club->k_id]) }}" method="post" id="form_add_player" class="collapse form-inline text-xs-center mb-1">
            {{ csrf_field() }}
            <select class="form-control" name="player">
                @foreach ($players_canAdd as $c)
                    <option value="{{ $c->z_id }}">{{ $c->z_imie }} {{ $c->z_nazwisko }}</option>
                @endforeach
            </select>
            <input type="submit" class="btn btn-success" value="dodaj" />
        </form>
    @endif

    @if(count($players) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Klub</th>
                        <th class="text-xs-center">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($players as $p)
                        <tr>
                            <td>{{ $p->z_imie }} {{ $p->z_nazwisko }}</td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.leagues.clubs.players.delete", ['id'=>$league->roz_id,'club_id'=>$club->k_id,'player_id'=>$p->z_id]) }}" class="btn btn-danger btn-sm" data-toggle="confirm" title="Na pewno chcesz usunąć tego zawodnika z tej drużyny?!">usuń z drużyny</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">brak zawodników</div>
    @endif

@endsection