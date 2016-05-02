<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use GuzzleHttp;

class UserInfoController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

    }

    /*
     * Get the users information
     *
     * @return array
     */
    public function getUserInfo($username)
    {
        // User to be returned
        $user = null;

        if($username != '') {
            // Build the query
            $endpoint = 'https://api.untappd.com/v4';
            $method = '/user/info/' . $username;
            $params = [
                'client_id' => getenv('CLIENT_ID'),
                'client_secret' => getenv('CLIENT_SECRET'),
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
            $user = $results['response']['user'];

            // Change the signup date to be human readable
            $user['date_joined'] = date('F jS, Y h:i:sa', strtotime($user['date_joined']));
        }

        return $user;
    }
}