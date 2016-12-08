@extends('theme')

@section('left')

    <h3>Strzelcy &raquo; <small>{{ $league->roz_liga }} - {{ $league->roz_nazwa }} (sezon {{ $league->roz_sezon }})</small></h3>

    @if(count($goals) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Lp.</th>
                        <th class="text-xs-center">Zawodnik</th>
                        <th class="text-xs-center">Drużyna</th>
                        <th class="text-xs-center">Ilość</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php $poprzedni = ""; ?>
                    @foreach ($goals as $g)
                        <tr>
                            <td class="text-xs-center">
                                @if ($poprzedni != $g->ilosc)
                                    {{ $i }}
                                @endif
                            </td>
                            <td>
                                {{ $info[$g->z_id] }}
                            </td>
                            <td>
                                @foreach ($info_clubs[$g->z_id] as $ic)
                                    {{ $ic->k_nazwa }}
                                @endforeach
                            </td>
                            <td class="text-xs-center">{{ $g->ilosc }}</td>
                        </tr>
                        <?php $poprzedni = $g->ilosc; ?>
                        <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">Brak strzelców w tej rozgrywce.</div>
    @endif

@endsection