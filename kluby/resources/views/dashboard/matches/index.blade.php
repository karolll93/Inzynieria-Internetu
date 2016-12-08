@extends('dashboard/layout')

@section('left')

    <h3>Panel administracyjny<small> &raquo; mecze</small></h3>

    <div class="text-xs-center mb-1"><a href="{{ route("dashboard.matches.add") }}" class="btn btn-success btn-sm">dodaj nowy mecz</a></div>

    @if ($message)
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if(count($matches) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Gospodarz</th>
                        <th class="text-xs-center">Gość</th>
                        <th class="text-xs-center">Wynik</th>
                        <th class="text-xs-center">Rozgrywka</th>
                        <th colspan="3" class="text-xs-center">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matches as $m)
                        <tr>
                            <td>{{ $m->gospodarz }}</td>
                            <td>{{ $m->gosc }}</td>
                            <td class="text-xs-center">
                                @if ($m->m_rozegrany == 't')
                                    {{ $m->m_bramki1 }}:{{ $m->m_bramki2 }}
                                @else
                                    nierozegrany
                                @endif
                            </td>
                            <td>{{ $m->roz_nazwa }}<br /><small>(sezon {{  $m->roz_sezon }})</small></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.matches.goals", ['id'=>$m->m_id]) }}" class="btn btn-warning btn-sm">gole ({{ $goals[$m->m_id] }})</a></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.matches.edit", ['id'=>$m->m_id]) }}" class="btn btn-primary btn-sm">edytuj</a></td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.matches.delete", ['id'=>$m->m_id]) }}" class="btn btn-danger btn-sm" data-toggle="confirm" title="Na pewno chcesz usunąć ten mecz?!">usuń</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">brak meczów</div>
    @endif

@endsection