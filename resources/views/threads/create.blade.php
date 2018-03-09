@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-header">Create a New Thread</div>

                <div class="card-body">
                    <form method="POST" action="/threads">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : ''}}" name="title" id="title" value="{{ old('title') }}">
                            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea name="body" id="body" class="form-control" rows="10" {{ $errors->has('body') ? 'is-invalid' : ''}}>{{ old('body') }}</textarea>
                            <div class="invalid-feedback">{{ $errors->first('body') }}</div>
                        </div>

                        <button type="submit" class="btn btn-primary">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
