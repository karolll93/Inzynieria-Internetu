@extends('dashboard/layout')

@section('left')

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
            <label for="iae_name" class="offset-md-2 col-md-2 col-form-label">Nazwa<span class="required">*</span>:</label>
            <div class="col-md-6">
                <input class="form-control" name="name" value="{{ $name }}" type="text" placeholder="nazwa" id="iae_name" maxlength="100" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="iae_country_id" class="offset-md-2 col-md-2 col-form-label">Państwo<span class="required">*</span>:</label>
            <div class="col-md-6">
                <select class="form-control" id="iae_country_id" name="country_id" required>
                    @foreach ($countries as $c)
                        @if ($c->p_id == $country_id)
                            <option value="{{ $c->p_id }}" selected="selected">{{ $c->p_nazwa }}</option>
                        @else
                            <option value="{{ $c->p_id }}">{{ $c->p_nazwa }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-md-4 col-md-6">
                <input type="submit" name="save" value="{{ $mode }}" class="btn btn-success" />
                <div class="float-xs-right"><a href="{{ route("dashboard.clubs") }}" class="btn btn-primary">powrót</a></div>
            </div>
        </div>
    </form>

@endsection