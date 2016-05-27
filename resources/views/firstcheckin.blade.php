@extends('app')

@section('content')
    <h1 class="pageTitle">First Checkin</h1>

    <div class="row">
        <div class="small-12 medium-12 large-6 columns">
            <form>
                <div class="input-group">
                    <span class="input-group-label"><label for="username">Username:</label></span>
                    <input type="text" id="username" class="input-group-field" name="username" value="{{ $username }}" />
                    <div class="input-group-button">
                        <input type="submit" class="button" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(is_object($beer))
        <div class="report">
            <p><em>{{ $user['first_name'] }} {{ $user['last_name'] }}</em> signed up on <strong>{{ $user['date_joined'] }}</strong></p>

            <table>
                <thead>
                    <tr>
                        <td>Beer Name:</td>
                        <td>Checked In Date</td>
                        <td>Rating Score</td>
                        <td>Label Art</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $beer['beer']['beer_name'] }}</td>
                        <td>{{ $beer['first_created_at'] }}</td>
                        <td>{{ $beer['rating_score'] }}</td>
                        <td><img src="{{ $beer['beer']['beer_label'] }}"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @elseif($username != null)
        <p>{{ $username }} hasn't checked into a beer yet.</p>
    @endif

@endsection