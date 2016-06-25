<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Only initialize the database migration once flag
     *
     * @var boolean
     */
    protected static $db_init = false;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        // Migrate the database only once per run
        if (!static::$db_init) {
            // Migrate and refresh the DB
            Artisan::call('migrate:refresh');

            // Set this as true that we migrated it
            static::$db_init = true;
        }

        return $app;
    }
}
