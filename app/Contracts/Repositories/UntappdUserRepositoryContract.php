<?php namespace App\Contracts\Repositories;

Interface UntappdUserRepositoryContract
{
    /**
     * Find the users information from the Untappd API
     *
     * @param $username
     * @return mixed
     */
    public function find($username);
}
