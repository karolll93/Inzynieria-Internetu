@extends('theme')

@section('left')

    <div class="float-xs-right">
        <div class="btn-group">
            <a href="{{ route("leagues") }}" class="btn btn-warning btn-sm">powrót do rozgrywek</a>
            <a href="{{ route("leagues.matches", ["id"=>$league->roz_id])}}" class="btn btn-primary btn-sm">mecze</a>
            <a href="{{ route("leagues.goals", ["id"=>$league->roz_id])}}" class="btn btn-primary btn-sm">strzelcy</a>
        </div>
    </div>

    <h3>Tabela &raquo; <small>{{ $league->roz_liga }} - {{ $league->roz_nazwa }} (sezon {{ $league->roz_sezon }})</small></h3>

    @if(count($table) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Lp</th>
                        <th class="text-xs-center">Drużyna</th>
                        <th class="text-xs-center">Mecze</th>
                        <th class="text-xs-center">Punkty</th>
                        <th class="text-xs-center">Bramki</th>
                        <th class="text-xs-center">+/-</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $lp = 1; $old_points = ""; $old_goals = ""; ?>
                    @foreach ($table as $t)
                        <tr>
                            @if ($old_points == $t->points && $old_goals == $t->goals_scored - $t->goals_losted)
                                <td class="text-xs-center"></td>
                            @else
                                <td class="text-xs-center">{{ $lp }}</td>
                            @endif
                            <td>{{ $t->name }}</td>
                            <td class="text-xs-center">{{ $t->matches }}</td>
                            <td class="text-xs-center">{{ $t->points }}</td>
                            <td class="text-xs-center">{{ $t->goals_scored }}:{{ $t->goals_losted }}</td>
                            <td class="text-xs-center">{{ ($t->goals_scored - $t->goals_losted) }}</td>
                        </tr>
                        <?php $old_points = $t->points; ?>
                        <?php $old_goals = $t->goals_scored - $t->goals_losted; ?>
                        <?php $lp++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Brak drużyn w tej rozgrywce.</div>
    @endif

@endsection