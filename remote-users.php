<?php

/**
 * Plugin Name:       Remote users
 * Plugin URI:        https://www.vijayan.in
 * Description:       This plugin is fetch remote users and list them in a custom url page.
 * Author:            Vijayan
 * Author URI:        https://www.vijayan.in
 * Text Domain:       remote-users
 * Domain Path:       /languages
 * Version:           0.1.0
 * Requires at least: 5.5
 * Requires PHP:      7.3
 *
 * @package         Remote_Users
 */

declare(strict_types=1);

if (!function_exists('add_action')) {
    echo 'No direct access.';
    exit;
}

require_once(plugin_dir_path(__FILE__) . '/vendor/autoload.php');

define('REMOTE_USERS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('REMOTE_USERS_PLUGIN_URL', plugin_dir_url(__FILE__));
const REMOTE_USERS_VERSION = '0.1.0';

use Remote_Users\Utils\Routes;
use Remote_Users\Views\Render;
use Remote_Users\Utils\Deactivation;

/**
 * Fires once activated plugins have loaded.
 *
 */
add_action('plugins_loaded', [ Routes::class, 'rewriteHooks' ]);
add_action('plugins_loaded', [ Render::class, 'renderHooks' ]);

/**
 * Fires once plugin deactivated.
 *
 */
register_deactivation_hook(__FILE__, [ Deactivation::class, 'cleanUp' ]);
