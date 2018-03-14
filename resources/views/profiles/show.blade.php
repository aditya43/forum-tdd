@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $profileUser->name }}</h3>
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