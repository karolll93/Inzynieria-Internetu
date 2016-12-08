@extends('dashboard/layout')

@section('left')

    <h3>Panel administracyjny<small> &raquo; rozgrywki</small></h3>

    <div class="text-xs-center mb-1"><a href="{{ route("dashboard.leagues.add") }}" class="btn btn-success btn-sm">dodaj nową rozgrywkę</a></div>

    @if ($message)
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if(count($leagues) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Liga</th>
                        <th class="text-xs-center">Nazwa</th>
                        <th class="text-xs-center">Typ</th>
                        <th class="text-xs-center">Sezon</th>
                        <th colspan="2" class="text-xs-center">Zarządzaj</th>
                        <th colspan="2" class="text-xs-center">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leagues as $l)
                        <tr>
                            <td>{{ $l->roz_liga }}</td>
                            <td>{{ $l->roz_nazwa }}</td>
                            <td>{{ $l->roz_typ }}</td>
                            <td>{{ $l->roz_sezon }}</td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.leagues.clubs", ['id'=>$l->roz_id]) }}" class="btn btn-info btn-sm">kluby ({{ $clubs_count[$l->roz_id] }})</a></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.leagues.promotions", ['id'=>$l->roz_id]) }}" class="btn btn-warning btn-sm">awanse ({{ $promotion_count[$l->roz_id] }})</a></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.leagues.edit", ['id'=>$l->roz_id]) }}" class="btn btn-primary btn-sm">edytuj</a></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.leagues.delete", ['id'=>$l->roz_id]) }}" class="btn btn-danger btn-sm" data-toggle="confirm" title="Na pewno chcesz usunąć tę rozgrywkę?!">usuń</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">brak rozgrywek</div>
    @endif

@endsection