<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\FirstCheckinController;
use App\Repositories\UntappdUserRepository;
use App\Repositories\UntappdCheckinRepository;
use App\Repositories\CheckinRepository;
use App\Checkin;
use Carbon\Carbon;

class FirstCheckinControllerTest extends TestCase
{
    /**
     * Initialize the constructor
     *
     * @covers App\Http\Controllers\FirstCheckinController::__construct
     * @test
     */
    public function initialize_constructor()
    {
        $firstCheckinController = new FirstCheckinController(
            new UntappdUserRepository(new Carbon),
            new UntappdCheckinRepository(new Carbon),
            new CheckinRepository(new Checkin)
        );

        $this->assertEquals(get_class($firstCheckinController), FirstCheckinController::class);
    }

    /**
     * @covers App\Http\Controllers\FirstCheckinController::index
     * @test
     */
    public function index_with_no_username_should_show_form()
    {
        $this->visit('/first-checkin')
            ->see('First Checkin');
    }

    /**
     * @covers App\Http\Controllers\FirstCheckinController::index
     * @test
     */
    public function index_with_username_should_show_result()
    {
        $this->visit('/first-checkin')
            ->type('robertvrabel', 'username')
            ->press('Submit')
            ->see('<div class="report"');
    }
}
