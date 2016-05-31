<?php namespace App\Contracts\Repositories;

Interface UntappdCheckinRepositoryContract
{
    /**
     * Find the users checkins from the Untappd API
     *
     * @param $username
     * @param $sort
     * @param $limit
     * @return mixed
     */
    public function find($username, $sort, $limit);
}