@extends('app')

@section('content')
    <div class="row">
        <div class="large-12 columns">
            <h1>Welcome!</h1>

            <p>This site is designed to show you stats and reports from <a href="http://untappd.com/" target="_blank">Untappd</a>. Viewing your <a href="{{ action("FirstCheckinController@index") }}">first beer checkin</a> is available now, with more reports to come in the future!</p>

        </div>
    </div>
@endsection