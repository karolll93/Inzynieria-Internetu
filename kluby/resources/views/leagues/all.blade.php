@extends('theme')

@section('left')

    @if(count($leagues) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Liga</th>
                        <th class="text-xs-center">Sezon</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leagues as $league)
                        <tr>
                            <td>{{ $league->roz_liga }} &raquo; {{ $league->roz_nazwa }}</td>
                            <td class="text-xs-center">{{ $league->roz_sezon }}</td>
                            <td class="text-xs-center"><a href="{{ route("leagues.matches", ['id'=>$league->roz_id]) }}">mecze</a></td>
                            <td class="text-xs-center"><a href="{{ route("leagues.goals", ['id'=>$league->roz_id]) }}">strzelcy</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Brak rozgrywek.</div>
    @endif

@endsection