@extends('dashboard/layout')

@section('left')

    <script>
        function change_result(obj) {
            if (obj.checked) {
                document.getElementById('f_result').style.display = 'block';
            } else {
                document.getElementById('f_result').style.display = 'none';
            }
        }
    </script>

    <h3>{{ $title }}</h3>
    <form action="{{ $url }}" method="post">
        {{ csrf_field() }}
        @if ($errors)
            <div class="alert alert-danger">
                @foreach($errors as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif
        @if ($message)
            <div class="alert alert-success">{{ $message }}</div>
        @endif
        <div class="form-group row">
            <label for="iae_league_id" class="offset-md-2 col-md-2 col-form-label">Rozgrywka<span class="required">*</span>:</label>
            <div class="col-md-6">
                <input type="hidden" name="league_id" value="{{ $league_id }}" />
                <select class="form-control" id="iae_league_id" name="league_idX" disabled>
                    @foreach ($leagues as $l)
                        @if ($l->roz_id == $league_id)
                            <option value="{{ $l->roz_id }}" selected="selected">{{ $l->roz_nazwa }} - {{ $l->roz_liga }} (sezon {{ $l->roz_sezon }})</option>
                        @else
                            <option value="{{ $l->roz_id }}">{{ $l->roz_nazwa }} - {{ $l->roz_liga }}  (sezon {{ $l->roz_sezon }})</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_host_id" class="offset-md-2 col-md-2 col-form-label">Gospodarz<span class="required">*</span>:</label>
            <div class="col-md-6">
                <select class="form-control" id="iae_host_id" name="host_id" required>
                    @foreach ($clubs as $c)
                        @if ($c->rk_id == $host_id)
                            <option value="{{ $c->rk_id }}" selected="selected">{{ $c->k_nazwa }}</option>
                        @else
                            <option value="{{ $c->rk_id }}">{{ $c->k_nazwa }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_guest_id" class="offset-md-2 col-md-2 col-form-label">Gość<span class="required">*</span>:</label>
            <div class="col-md-6">
                <select class="form-control" id="iae_guest_id" name="guest_id" required>
                    @foreach ($clubs as $c)
                        @if ($c->rk_id == $guest_id)
                            <option value="{{ $c->rk_id }}" selected="selected">{{ $c->k_nazwa }}</option>
                        @else
                            <option value="{{ $c->rk_id }}">{{ $c->k_nazwa }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_date" class="offset-md-2 col-md-2 col-form-label">Data<span class="required">*</span>:</label>
            <div class="col-md-6">
                <input class="form-control" name="date" value="{{ $date }}" type="date" id="iae_date" maxlength="10" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_played" class="offset-md-2 col-md-2 col-form-label">Rozegrany:</label>
            <div class="col-md-6 col-form-label">
                @if ($played)
                    <input name="played" value="1" type="checkbox" onclick="change_result(this);" id="iae_played" checked="checked" />
                @else
                    <input name="played" value="1" type="checkbox" onclick="change_result(this);" id="iae_played" />
                @endif
            </div>
        </div>
        @if ($played)
            <div class="form-group row" id="f_result" style="display: block;">
        @else
            <div class="form-group row" id="f_result" style="display: none;">
        @endif
            <label class="offset-md-2 col-md-2 col-form-label">Wynik:</label>
            <div class="col-md-6 col-form-label">
                <div class="input-group">
                    <input class="form-control text-xs-right" type="text" name="goals1" value="{{ $goals1 }}" maxlength="2" />
                    <div class="input-group-addon">:</div>
                    <input class="form-control" type="text" name="goals2" value="{{ $goals2 }}" maxlength="2" />
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_place" class="offset-md-2 col-md-2 col-form-label">Miejsce:</label>
            <div class="col-md-6">
                <input class="form-control" name="place" value="{{ $place }}" type="text" placeholder="miejsce" id="iae_place" maxlength="200" />
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_viewers" class="offset-md-2 col-md-2 col-form-label">Widzów:</label>
            <div class="col-md-6">
                <input class="form-control" name="viewers" value="{{ $viewers }}" type="text" placeholder="widzów" id="iae_viewers" maxlength="6" />
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_referee" class="offset-md-2 col-md-2 col-form-label">Sędzia:</label>
            <div class="col-md-6">
                <input class="form-control" name="referee" value="{{ $referee }}" type="text" placeholder="sędzia" id="iae_referee" maxlength="100" />
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-md-4 col-md-6">
                <input type="submit" name="save" value="{{ $mode }}" class="btn btn-success" />
                <div class="float-xs-right"><a href="{{ route("dashboard.matches") }}" class="btn btn-primary">powrót</a></div>
            </div>
        </div>
    </form>

@endsection