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
     * Find a record by a column
     *
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return
     */
    public function findBy($attribute, $value, array $columns = ['*'])
    {
        return $this->checkin->where($attribute, $value)->first($columns);
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
