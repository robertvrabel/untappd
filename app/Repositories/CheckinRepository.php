<?php namespace App\Repositories;

use App\Checkin;
use App\Contracts\Repositories\CheckinRepositoryContract;

class CheckinRepository implements CheckinRepositoryContract
{
    /**
     * CheckinRepository constructor.
     * 
     * @param Checkin $checkin
     */
    public function __construct(Checkin $checkin)
    {
        $this->checkin = $checkin;
    }

    /**
     * Find the users checkin
     *
     * @param $username
     * @return mixed
     */
    public function find($username)
    {
        return $this->checkin->where('username', $username)->first();
    }

    /**
     * Create a checkin record
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->checkin->create($data);
    }
}