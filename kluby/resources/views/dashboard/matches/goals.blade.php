@extends('dashboard/layout')

@section('left')

    <div class="float-xs-right"><a href="{{ route("dashboard.leagues") }}" class="btn btn-primary btn-sm">powrót</a></div>

    <h3>Panel administracyjny<small> &raquo; gole w meczu</small></h3>

    <p>Mecz: <strong>{{ $match->gospodarz }} vs {{ $match->gosc }}</strong>
        @if ($match->m_rozegrany == 't')
            {{ $match->m_bramki1 }}:{{  $match->m_bramki2 }}
        @else
            nierozegrany
        @endif
    </p>
    <p>Rozgrywka: <strong>{{ $match->roz_liga }} - {{ $match->roz_nazwa }} (sezon {{ $match->roz_sezon }})</strong></p>

    @if ($message)
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if ($show_form)
        <form action="{{ $url }}" method="post">
            {{ csrf_field() }}
            @if ($errors)
                <div class="alert alert-danger">
                    @foreach($errors as $e)
                        <div>{{ $e }}</div>
                    @endforeach
                </div>
            @endif
            <hr />
            <div class="form-group row">
                <label for="iae_player_id" class="offset-md-2 col-md-2 col-form-label">Zawodnik<span class="required">*</span>:</label>
                <div class="col-md-6">
                <select class="form-control" id="iae_player_id" name="player_id">
                    @if (count($players_host) > 0)
                        <option disabled>&raquo; {{ $match->gospodarz }}</option>
                        @foreach ($players_host as $c)
                            <option value="{{ $c->kzaw_id }}">{{ $c->z_imie }} {{ $c->z_nazwisko }}</option>
                        @endforeach
                    @endif
                    @if (count($players_guest) > 0)
                        <option disabled>&raquo; {{ $match->gosc }}</option>
                        @foreach ($players_guest as $c)
                            <option value="{{ $c->kzaw_id }}">{{ $c->z_imie }} {{ $c->z_nazwisko }}</option>
                        @endforeach
                    @endif
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="iae_type" class="offset-md-2 col-md-2 col-form-label">Typ:</label>
                <div class="col-md-6">
                    <input class="form-control" name="type" value="" type="text" id="iae_type" maxlength="10" /> np. <strong>karny</strong>
                </div>
            </div>
            <div class="form-group row">
                <label for="iae_min" class="offset-md-2 col-md-2 col-form-label">Minuta:</label>
                <div class="col-md-6">
                    <input class="form-control" name="min" value="" type="text" id="iae_min" maxlength="3" />
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-md-4 col-md-6">
                    <input type="submit" name="save" value="dodaj" class="btn btn-success" />
                    <div class="float-xs-right"><a href="{{ route("dashboard.matches.goals", ['id'=>$match->m_id]) }}" class="btn btn-primary">powrót</a></div>
                </div>
            </div>
            <hr />
        </form>
    @else
        <div class="text-xs-center mb-1"><a href="{{ route("dashboard.matches.goals.add", ['id'=>$match->m_id]) }}" class="btn btn-success btn-sm">dodaj nowego gola</a></div>
    @endif

    @if(count($goals) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Drużyna</th>
                        <th class="text-xs-center">Zawodnik</th>
                        <th class="text-xs-center">Typ</th>
                        <th class="text-xs-center">Minuta</th>
                        <th class="text-xs-center">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($goals as $g)
                        <tr>
                            <td>{{ $g->k_nazwa }}</td>
                            <td>{{ $g->z_imie }} {{ $g->z_nazwisko }}</td>
                            <td class="text-xs-center">{{ $g->g_typ or 'zwykły' }}</td>
                            <td class="text-xs-center">{{ $g->g_min or 'nie podano' }}</td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.matches.goals.delete", ['id'=>$match->m_id,'goal_id'=>$g->g_id]) }}" class="btn btn-danger btn-sm" data-toggle="confirm" title="Na pewno chcesz usunąć tego gola?!">usuń</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">brak goli</div>
    @endif

@endsection