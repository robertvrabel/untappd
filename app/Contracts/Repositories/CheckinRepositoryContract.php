<?php namespace App\Contracts\Repositories;

Interface CheckinRepositoryContract
{
    /**
     * Find the users information
     *
     * @param $username
     * @return mixed
     */
    public function findBy($attribute, $value, array $columns);

    /**
     * Create a checkin record
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);
}