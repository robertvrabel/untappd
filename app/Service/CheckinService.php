<?php namespace App\Service;

use Remic\GuzzleCache\Facades\GuzzleCache;
use Carbon\Carbon;

class CheckinService
{
    /**
     * CheckinService constructor.
     *
     * @param Carbon $carbon
     */
    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
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