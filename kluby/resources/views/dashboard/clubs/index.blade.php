@extends('dashboard/layout')

@section('left')

    <h3>Panel administracyjny<small> &raquo; kluby</small></h3>

    <div class="text-xs-center mb-1"><a href="{{ route("dashboard.clubs.add") }}" class="btn btn-success btn-sm">dodaj nowy klub</a></div>

    @if ($message)
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if(count($clubs) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Państwo</th>
                        <th colspan="2" class="text-xs-center">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clubs as $c)
                        <tr>
                            <td>{{ $c->k_nazwa }}</td>
                            <td>{{ $c->panstwo_nazwa }}</td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.clubs.edit", ['id'=>$c->k_id]) }}" class="btn btn-primary btn-sm">edytuj</a></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.clubs.delete", ['id'=>$c->k_id]) }}" class="btn btn-danger btn-sm" data-toggle="confirm" title="Na pewno chcesz usunąć ten klub?!">usuń</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">brak klubów</div>
    @endif

@endsection