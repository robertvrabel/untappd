<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use GuzzleHttp;
use Illuminate\Support\Facades\Input;

class FirstCheckinController extends Controller
{
    /** @var UserInfoController */
    protected $user;

    /**
     * FirstCheckinController constructor.
     *
     * @param UserInfoController $user
     */
    public function __construct(UserInfoController $user) {
        
        $this->user = $user;
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
        $user = $this->user->getUserInfo($username);

        // Get the first checkin
        $beer = $this->getFirstCheckin($username);

        return view('firstcheckin', compact('beer', 'user', 'username'));
    }

    public function getFirstCheckin($username)
    {
        // Beer to be returned
        $beer = null;

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
            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', $endpoint . $method, [
                'query' => $params
            ]);

            // Get the results
            $raw = $res->getBody();

            // Decode the results
            $results = json_decode($raw, true);

            // Set the item
            $beer = current($results['response']['beers']['items']);

            // Change the date to human readable
            $beer['first_created_at'] = date('F jS, Y h:i:sa', strtotime($beer['first_created_at']));
        }

        return $beer;
    }
}
