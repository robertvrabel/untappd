<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\UntappdUserRepository;
use Carbon\Carbon;

class UntappdUserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @var UntappdUserRepository */
    protected $untappdUserRepository;

    public function setUp()
    {
        parent::setUp();

        $this->untappdUserRepository = new UntappdUserRepository(new Carbon);
    }

    /**
     * Initialize the constructor
     *
     * @covers App\Repositories\UntappdUserRepository::__construct
     * @test
     */
    public function initialize_constructor()
    {
        $untappdUserRepository = new UntappdUserRepository(new Carbon);

        $this->assertEquals(get_class($untappdUserRepository), UntappdUserRepository::class);
    }

    /**
     * @covers App\Repositories\UntappdUserRepository::find
     * @test
     */
    public function find_should_find_untappd_user()
    {
        $user = $this->untappdUserRepository->find('robertvrabel');

        $this->assertArrayHasKey('user_name', $user);
    }
}
