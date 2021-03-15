<?php

declare(strict_types=1);

use Remote_Users\Views\Render;

class RenderTest extends PluginTestCase
{

    public function testRenderHooks()
    {

        Render::renderHooks();
        self::assertNotFalse(has_action('remote-users/template/before-main-content'));
        self::assertNotFalse(has_action('remote-users/template/main-content'));
        self::assertNotTrue(has_action('remote-users/template/after-main-content'));
    }
}
