<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Repositories\UntappdCheckinRepository;

class UntappdCheckinRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @var UntappdCheckinRepository */
    protected $untappdCheckinRepository;

    public function setUp()
    {
        parent::setUp();

        $this->untappdCheckinRepository = new UntappdCheckinRepository(new Carbon);
    }

    /**
     * Initialize the constructor
     *
     * @covers App\Repositories\UntappdCheckinRepository::__construct
     * @test
     */
    public function initialize_constructor()
    {
        $untappdCheckinRepository = new UntappdCheckinRepository(new Carbon);

        $this->assertEquals(get_class($untappdCheckinRepository), UntappdCheckinRepository::class);
    }

    /**
     * @covers App\Repositories\UntappdCheckinRepository::find
     * @test
     */
    public function find_should_return_checkins()
    {
        $checkin = $this->untappdCheckinRepository->find('robertvrabel', 'date_asc', 1);
        
        $this->assertArrayHasKey('beer', $checkin);
    }
}
