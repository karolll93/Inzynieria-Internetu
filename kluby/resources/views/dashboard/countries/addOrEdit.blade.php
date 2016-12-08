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
            <label for="iae_short" class="offset-md-2 col-md-2 col-form-label">Skrót<span class="required">*</span>:</label>
            <div class="col-md-6">
                <input class="form-control" name="short" value="{{ $short  }}" type="text" placeholder="skrót" id="iae_short" maxlength="10" required />
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-md-4 col-md-6">
                <input type="submit" name="save" value="{{ $mode }}" class="btn btn-success" />
                <div class="float-xs-right"><a href="{{ route("dashboard.countries") }}" class="btn btn-primary">powrót</a></div>
            </div>
        </div>
    </form>

@endsection