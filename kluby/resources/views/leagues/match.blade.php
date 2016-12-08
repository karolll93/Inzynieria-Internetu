@extends('theme')

@section('left')

    <div class="float-xs-right">
        <div class="btn-group">
                <a href="{{ route("leagues") }}" class="btn btn-warning btn-sm">powrót do rozgrywek</a>
                <a href="{{ route("leagues.table", ["id"=>$league->roz_id])}}" class="btn btn-primary btn-sm">tabela</a>
                <a href="{{ route("leagues.goals", ["id"=>$league->roz_id])}}" class="btn btn-primary btn-sm">strzelcy</a>
        </div>
    </div>

    <h3>Rozgrywka &raquo; <small>{{ $league->roz_liga }} - {{ $league->roz_nazwa }} (sezon {{ $league->roz_sezon }})</small></h3>

    @if(count($matches) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Spotkanie</th>
                        <th class="text-xs-center">Data</th>
                        <th class="text-xs-center">Miejsce</th>
                        <th class="text-xs-center">Sędzia</th>
                        <th class="text-xs-center">Widzów</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matches as $match)
                        <tr>
                            <td>{{ $match->gospodarz }} - {{ $match->gosc }}
                                @if ($match->m_rozegrany == 't')
                                    {{  $match->m_bramki1 }}:{{  $match->m_bramki2 }}
                                @else
                                    nierozegrany
                                    @endif
                            </td>
                            <td class="text-xs-center">
                                {{ substr($match->m_data, 8, 2) }}.{{ substr($match->m_data, 5, 2) }}.{{ substr($match->m_data, 0, 4) }}
                            </td>
                            <td class="text-xs-center">
                                @if ($match->m_miejsce)
                                    {{ $match->m_miejsce }}
                                @else
                                    nie podano
                                @endif
                            </td>
                            <td class="text-xs-center">
                                @if ($match->m_sedzia)
                                    {{ $match->m_sedzia }}
                                @else
                                    nie podano
                                @endif
                            </td>
                            <td class="text-xs-center">
                                @if ($match->m_widzow)
                                    {{ $match->m_widzow }}
                                @else
                                    nie podano
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Brak meczów w tej rozgrywce.</div>
    @endif

@endsection