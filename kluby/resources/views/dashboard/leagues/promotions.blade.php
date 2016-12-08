@extends('dashboard/layout')

@section('left')

    <div class="float-xs-right"><a href="{{ route("dashboard.leagues") }}" class="btn btn-primary btn-sm">powrót</a></div>

    <h3>Panel administracyjny<small> &raquo; awanse w rozgrywce</small></h3>

    <p>Rozgrywka: <strong>{{ $league->roz_liga }} - {{ $league->roz_nazwa }} (sezon {{ $league->roz_sezon }})</strong></p>

    @if ($message)
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if ($message_error)
        <div class="alert alert-danger">{{ $message_error }}</div>
    @endif

    @if (count($clubs) > 0)
        <div class="text-xs-center mb-1"><a href="#" data-toggle="collapse" data-target="#form_add_promotion" class="btn btn-success btn-sm">dodaj wpis</a></div>
        <form action="{{ route("dashboard.leagues.promotions", ["id"=>$league->roz_id]) }}" method="post" id="form_add_promotion" class="collapse text-xs-center mb-1">
            <hr />
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="iae_club_id" class="offset-md-2 col-md-2 col-form-label">Klub<span class="required">*</span>:</label>
                <div class="col-md-6">
                    <select id="iae_club_id" class="form-control" name="club_id" required="required">
                    @foreach ($clubs as $c)
                        @if ($c->k_id == $club_id)
                            <option value="{{ $c->k_id }}" selected="selected">{{ $c->k_nazwa }}</option>
                        @else
                            <option value="{{ $c->k_id }}">{{ $c->k_nazwa }}</option>
                        @endif
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="iae_profit" class="offset-md-2 col-md-2 col-form-label">Zysk:</label>
                <div class="col-md-6">
                    <input class="form-control" name="profit" value="{{ $profit }}" type="text" placeholder="zysk" maxlength="10" />
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-md-2 col-md-6">
                    <input type="submit" class="btn btn-success" value="dodaj" />
                </div>
            </div>
        </form>
    @endif

    @if(count($promotions) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-xs-center">Klub</th>
                        <th class="text-xs-center">Zysk</th>
                        <th colspan="2" class="text-xs-center">Opcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promotions as $p)
                        <tr>
                            <td>{{ $p->k_nazwa }}</td>
                            <td class="text-xs-center">
                            @if ($p->ag_zysk > 0)
                                {{ $p->ag_zysk }} €
                            @endif     
                            </td>
                            <td class="text-xs-center"><a href="{{ route("dashboard.leagues.promotions.delete", ['id'=>$league->roz_id,'club_id'=>$p->k_id]) }}" class="btn btn-danger btn-sm" data-toggle="confirm" title="Na pewno chcesz usunąć ten wpis?!">usuń wpis</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">brak wpisów</div>
    @endif

@endsection