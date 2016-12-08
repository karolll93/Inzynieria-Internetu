@extends('dashboard/layout')

@section('left')

    <h3>Panel administracyjny<small> &raquo; państwa</small></h3>

    <div class="text-xs-center mb-1"><a href="{{ route("dashboard.countries.add") }}" class="btn btn-success btn-sm">dodaj nowe państwo</a></div>

    @if ($message)
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if(count($countries) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Skrót</th>
                        <th colspan="2" class="text-xs-center">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countries as $c)
                        <tr>
                            <td>{{ $c->p_nazwa }}</td>
                            <td>{{ $c->p_skrot }}</td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.countries.edit", ['id'=>$c->p_id]) }}" class="btn btn-primary btn-sm">edytuj</a></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.countries.delete", ['id'=>$c->p_id]) }}" class="btn btn-danger btn-sm" data-toggle="confirm" title="Na pewno chcesz usunąć to państwo?!">usuń</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">brak państw</div>
    @endif

@endsection