<?php namespace App\Service;

use Remic\GuzzleCache\Facades\GuzzleCache;
use Carbon\Carbon;

class UserService
{
    /**
     * UserService constructor.
     * 
     * @param Carbon $carbon
     */
    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
    }

    /**
     * Get the users information
     *
     * @param $username
     * @return \Illuminate\Support\Collection|static
     */
    public function getUserInfo($username)
    {
        // User to be returned
        $user = collect();

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

                // Set the user
                $user = collect($results['response'])->flatMap(function($item) {
                    // Use carbon to convert to eastern timezone
                    $date = $this->carbon->createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($item['date_joined'])))->timezone('Pacific/Nauru')->setTimezone('America/Toronto');

                    // Change the signup date to be human readable
                    $item['date_joined'] = date('F jS, Y h:i:sa', strtotime($date->toDateTimeString()));

                    return $item;
                });
            }
        }

        return $user;
    }
}