@extends('app')

@section('content')
    <div class="row">
        <div class="large-12 columns">
            <h1>Welcome!</h1>

            <p>Seeing your <a href="{{ route('firstcheckin.index') }}">first checkin</a> from <a href="http://untappd.com/" target="_blank">Untappd</a> is now available!</p>
        </div>
    </div>
@endsection