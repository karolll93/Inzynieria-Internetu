@extends('dashboard/layout')

@section('left')

    <h3>Panel administracyjny<small> &raquo; zawodnicy</small></h3>

    <div class="text-xs-center mb-1"><a href="{{ route("dashboard.players.add") }}" class="btn btn-success btn-sm">dodaj nowego zawodnika</a></div>

    @if ($message)
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if(count($players) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nazwisko</th>
                        <th>Imię</th>
                        <th>Państwo</th>
                        <th colspan="2" class="text-xs-center">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($players as $p)
                        <tr>
                            <td>{{ $p->z_nazwisko }}</td>
                            <td>{{ $p->z_imie }}</td>
                            <td>{{ $p->panstwo_nazwa }}</td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.players.edit", ['id'=>$p->z_id]) }}" class="btn btn-primary btn-sm">edytuj</a></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.players.delete", ['id'=>$p->z_id]) }}" class="btn btn-danger btn-sm" data-toggle="confirm" title="Na pewno chcesz usunąć tego zawodnika?!">usuń</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">brak zawodników</div>
    @endif

@endsection