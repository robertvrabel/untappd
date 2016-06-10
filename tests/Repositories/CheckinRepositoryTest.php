<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\CheckinRepository;
use App\Checkin;

class CheckinRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @var FolderRepository */
    protected $checkinRepository;

    public function setUp()
    {
        parent::setUp();

        $this->checkinRepository = new CheckinRepository(new Checkin);
    }

    /**
     * Initialize the constructor
     *
     * @covers App\Repositories\CheckinRepository::__construct
     * @test
     */
    public function initialize_constructor()
    {
        $checkinRepository = new CheckinRepository(new Checkin);

        $this->assertEquals(get_class($checkinRepository), CheckinRepository::class);
    }

    /**
     * @covers App\Repositories\CheckinRepository::findBy
     * @test
     */
    public function find_by_should_find_same_column_and_value_in_database()
    {
        // Create a checkin
        $checkin = factory(App\Checkin::class)->create();

        $checkinDb = $this->checkinRepository->findBy('username', $checkin->username);

        $this->assertEquals($checkin->username, $checkinDb->username);
    }

    /**
     * @covers App\Repositories\CheckinRepository::create
     * @test
     */
    public function create_should_create_same_record_in_database()
    {
        $checkin = factory(App\Checkin::class)->make();

        $created_checkin = $this->checkinRepository->create($checkin->toArray());

        collect($checkin->toArray())->each(function($checkin, $key) use($created_checkin) {
            $this->assertEquals($checkin, $created_checkin[$key]);
        });
    }
}
