@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $profileUser->name }}</h3>
            @can('update', $profileUser)
            <form action="{{ route('avatar', $profileUser) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="avatar">
                <button type="submit" class="btn btn-primary">Add Avatar</button>
            </form>
            @endcan
            <img src="{{ $profileUser->avatar() }}" width="50">
            <hr>

            @forelse ($activities as $date => $activity)
            <h3>{{ $date }}</h3>

            @foreach ($activity as $record)
            @if (view()->exists("profiles.activities.{$record->type}"))
            @include("profiles.activities.{$record->type}", ['activity' => $record])
            @endif
            @endforeach
            @empty
            <h4>There is no activity for this user yet.</h4>
            @endforelse

        </div>
    </div>
</div>
@endsection