<?php

/**
 * Handles things to do on deactivation.
 */

declare(strict_types=1);

namespace Remote_Users\Utils;

/**
 * Class to handle deactivation logic.
 */
class Deactivation
{
    /**
     * Cleanup caches.
     *
     * Removed transient and flush the rewrite rule.
     *
     * @return void
     */
    public static function cleanUp(): void
    {
        flush_rewrite_rules();

        $remoteInstance = new Remote();
        delete_transient($remoteInstance->transKey());
    }
}
