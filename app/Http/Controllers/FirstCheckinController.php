<?php
namespace App\Http\Controllers;

use App\Contracts\Repositories\UntappdUserRepositoryContract;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Checkin;
use Remic\GuzzleCache\Facades\GuzzleCache;
use Carbon\Carbon;

class FirstCheckinController extends Controller
{
    /** @var UntappdUserRepositoryContract */
    protected $user;

    /** @var Checkin */
    protected $checkin;

    /** @var Carbon */
    protected $carbon;

    /**
     * FirstCheckinController constructor.
     *
     * @param UntappdUserContract $user
     * @param Checkin $checkin
     * @param Carbon $carbon
     */
    public function __construct(UntappdUserRepositoryContract $user, Checkin $checkin, Carbon $carbon) {
        $this->user = $user;
        $this->checkin = $checkin;
        $this->carbon = $carbon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get the requested username
        $username = Input::get('username');

        // Get the users info
        $user = $this->user->find($username);

        // Get the first checkin
        $beer = $this->getFirstCheckin($username);

        if(count($user) > 0 && count($beer) > 0) {
            // Check if this user is already in the database
            $checked_in_user = $this->checkin->where('username', $user['user_name'])->first();

            // Only store the user once in the database
            if(!isset($checked_in_user->id)) {
                $this->store([
                    'signup_date' => date('Y-m-d H:i:s', strtotime($user['date_joined'])),
                    'checkin_date' => date('Y-m-d H:i:s', strtotime($beer['first_created_at'])),
                    'username' => $user['user_name'],
                    'name' => $user['first_name'] . ' ' . $user['last_name'],
                    'beer' => $beer['beer']['beer_name'],
                    'rating' => $beer['rating_score'],
                    'label_art' => $beer['beer']['beer_label'],
                ]);
            }
        }

        return view('firstcheckin', compact('beer', 'user', 'username'));
    }

    /**
     * Store a new checkin
     *
     * @param null $checkin
     * @return boolean
     */
    public function store($checkin = null)
    {
        // Validate the request
        if($checkin != null) {
            // Store it
            $this->checkin->create($checkin);

            return true;
        }

        return false;
    }

    /**
     * Get the users first checkin
     *
     * @param null $username
     * @return \Illuminate\Support\Collection|static
     */
    public function getFirstCheckin($username = null)
    {
        // Beer to be returned
        $beer = collect();

        // Make sure we have a username
        if($username != null) {
            // Build the query
            $endpoint = 'https://api.untappd.com/v4';
            $method = '/user/beers/' . $username;
            $params = [
                'client_id' => getenv('CLIENT_ID'),
                'client_secret' => getenv('CLIENT_SECRET'),
                'sort' => 'date_asc',
                'limit' => 1,
            ];

            // Query for the results
            $client = GuzzleCache::client();

            $response = $client->get($endpoint . $method, [
                'timeout' => 10,
                'exceptions' => false,
                'connect_timeout' => 10,
                'query' => $params,
            ]);

            // If guzzle is successful
            if($response->getStatusCode() == 200) {
                // Get the results
                $results = $response->json();

                // Set the item
                $beer = collect($results['response']['beers']['items'])->flatMap(function($item) {
                    // Use carbon to convert to eastern timezone
                    $date = $this->carbon->createFromFormat('Y-m-d g:i:s', date('Y-m-d g:i:s', strtotime($item['first_created_at'])))->timezone('Pacific/Nauru')->setTimezone('America/Toronto');

                    // Change the date to human readable
                    $item['first_created_at'] = date('F jS, Y g:i:sa', strtotime($date->toDateTimeString()));

                    return $item;
                });
            }
        }

        return $beer;
    }
}
