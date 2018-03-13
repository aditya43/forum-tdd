@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3>{{ $profileUser->name }}</h3>            
            <hr>
            @foreach ($activities as $date => $activity)
                <h3>{{ $date }}</h3> <hr>
                @foreach ($activity as $record)
                    @include("profiles.activities.{$record->type}", ['activity' => $record])                    
                @endforeach
            @endforeach
        </div>
    </div>    
</div>    
@endsection