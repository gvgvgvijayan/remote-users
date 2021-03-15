<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;

/**
 * An abstraction over Monkey to do things fast
 * It also uses the snapshot trait
 */
class PluginTestCase extends TestCase
{
    //use MatchesSnapshots;
    use MockeryPHPUnitIntegration;

    /**
     * Setup which calls \Monkey setup
     *
     * @return void
     */
    public function setUp(): void
    {

        parent::setUp();
        Monkey\setUp();
    }

    /**
     * Teardown which calls \WP_Mock tearDown
     *
     * @return void
     */
    public function tearDown(): void
    {

        Monkey\tearDown();
        parent::tearDown();
    }
}
