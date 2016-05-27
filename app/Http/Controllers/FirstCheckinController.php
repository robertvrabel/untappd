<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Service\UserService;
use App\Service\CheckinService;

class FirstCheckinController extends Controller
{
    /** @var UserInfoController */
    protected $user;

    /**
     * FirstCheckinController constructor.
     *
     * @param UserInfoController $user
     */
    public function __construct(UserService $user, CheckinService $checkin) {

        $this->user = $user;
        $this->checkin = $checkin;
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
        $user = $this->user->getUserInfo($username);

        // Get the first checkin
        $beer = $this->checkin->getFirstCheckin($username);

        return view('firstcheckin', compact('beer', 'user', 'username'));
    }
}
