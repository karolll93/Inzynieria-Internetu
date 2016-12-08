@extends('layout')

@section('content')

    <div class="row">

        <div class="col-sm-9">
            <div id="left">
                @yield('left')
            </div>
        </div>

        <div class="col-sm-3">
            <div id="right">
                <?php $ile = 2; $max = 7; $rand = array(); ?>
                <?php for ($i = 1; $i <= $ile; $i++): ?>
                    <?php while (1) {
                        $r = rand(1, $max);
                        if (!in_array($r, $rand)) break;
                    } ?>
                    <?php $rand[] = $r; ?>
                    <img src="{{ url("img/image".$r.".jpg") }}" alt="" />
                    <p style="font-size: 11px; text-align: center;">fot. Sky Sports</p>
                <?php endfor ?>
            </div>
        </div>

    </div>

@endsection