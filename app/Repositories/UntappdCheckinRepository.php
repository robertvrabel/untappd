<?php namespace App\Repositories;

use App\Contracts\Repositories\UntappdCheckinRepositoryContract;
use Remic\GuzzleCache\Facades\GuzzleCache;
use Carbon\Carbon;

class UntappdCheckinRepository implements UntappdCheckinRepositoryContract
{
    /** @var Carbon */
    private $carbon;

    /**
     * UntappdCheckinRepository constructor.
     *
     * @param Carbon $carbon
     */
    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
    }

    /**
     * @param $username
     * @param $sort
     * @param $limit
     * @return \Illuminate\Support\Collection|static
     */
    public function find($username, $sort, $limit)
    {
        // Beer to be returned
        $beer = collect();

        // Build the query
        $endpoint = 'https://api.untappd.com/v4';
        $method = '/user/beers/' . $username;
        $params = [
            'client_id' => getenv('UNTAPPD_CLIENT_ID'),
            'client_secret' => getenv('UNTAPPD_CLIENT_SECRET'),
            'sort' => $sort != null ? $sort : 'date_asc',
            'limit' => $limit != null ? $limit : 1,
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

        return $beer;
    }
}