<?php
namespace App\Http\Controllers;

use App\Contracts\Repositories\UntappdUserRepositoryContract;
use App\Contracts\Repositories\UntappdCheckinRepositoryContract;
use App\Contracts\Repositories\CheckinRepositoryContract;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class FirstCheckinController extends Controller
{
    /** @var UntappdUserRepositoryContract */
    protected $user;

    /** @var UntappdCheckinRepositoryContract */
    protected $untappdCheckin;

    /** @var CheckinRepository */
    protected $checkin;

    /**
     * FirstCheckinController constructor.
     *
     * @param UntappdUserRepositoryContract $untappdUserRepository
     * @param UntappdCheckinRepositoryContract $untappdCheckinRepository
     * @param CheckinRepository $checkinRepository
     */
    public function __construct(UntappdUserRepositoryContract $untappdUserRepository, UntappdCheckinRepositoryContract $untappdCheckinRepository, CheckinRepositoryContract $checkinRepository) {
        $this->untappdUserRepository = $untappdUserRepository;
        $this->untappdCheckinRepository = $untappdCheckinRepository;
        $this->checkinRepository = $checkinRepository;
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
        $user = $this->untappdUserRepository->find($username);

        // Get the first checkin
        $beer = $this->untappdCheckinRepository->find($username, 'date_asc', 1);

        if(count($user) > 0 && count($beer) > 0) {
            // Check if this user is already in the database
            $checked_in_user = $this->checkinRepository->findBy('username', $user['user_name']);

            // Only store the user once in the database
            if(!isset($checked_in_user->id)) {
                $this->checkinRepository->create([
                    'signup_date' => date('Y-m-d H:i:s', strtotime($user['date_joined'])),
                    'checkin_date' => date('Y-m-d H:i:s', strtotime($beer['first_created_at'])),
                    'username' => $user['user_name'],
                    'name' => $user['first_name'] . ' ' . $user['last_name'],
                    'beer' => $beer['beer']['beer_name'],
                    'rating' => $beer['rating_score'],
                    'label_art' => $beer['beer']['beer_label'],
                ]);
            }
        }

        return view('firstcheckin', compact('beer', 'user', 'username'));
    }
}
