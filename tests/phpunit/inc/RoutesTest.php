<?php

declare(strict_types=1);

use Remote_Users\Utils\Routes;

class RoutesTest extends PluginTestCase
{

    public function testAddQueryKey()
    {

        $routes = new Routes();
        $querVars = $routes->addQueryKey(['test-url']);

        self::assertIsArray($querVars);
        self::assertContainsEquals('r-users', $querVars);
    }
}
