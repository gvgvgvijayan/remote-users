<?php

/**
 * Handles content rendering and assets.
 */

declare(strict_types=1);

namespace Remote_Users\Views;

use Remote_Users\Utils\Remote;

/**
 * Class responsible for content rendering and assets handling.
 */
class Render
{

    /**
     * Hook method.
     *
     * Hooks the methods to the actions.
     *
     * @static
     *
     * @return void
     */
    public static function renderHooks(): void
    {
        $render = new self();

        add_action('wp_enqueue_scripts', [ $render, 'addFrontEndAssets' ]);
        add_action('remote-users/template/before-main-content', [ $render, 'pageTitle' ]);
        add_action('remote-users/template/main-content', [ $render, 'mainContent' ]);
    }

    /**
     * Page title.
     *
     * Renders the table virtual page's heading.
     *
     * @return void
     */
    public function pageTitle(): void
    {
        $title = __('Remote Users', 'remote-users');
        $text = apply_filters('remote-users/filter/page-title', "<h1>$title</h1>");
        echo wp_kses_post($text);
    }

    /**
     * Main content.
     *
     * Renders the table virtual page's main content.
     *
     * @return void
     */
    public function mainContent(): void
    {
        $remote = new Remote();

        global $remoteUsers;
        $remoteUsers = apply_filters('remote-users/filter/page-data', $remote->users());

        include_once REMOTE_USERS_PLUGIN_DIR . 'templates/partials/table.php';
    }

    /**
     * Enqueue assets.
     *
     * Enqueued Jquery and Jquery UI dialog for popup.
     *
     * @return void
     */
    public function addFrontEndAssets(): void
    {
        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_enqueue_script(
            'remote-users-script',
            REMOTE_USERS_PLUGIN_URL . 'assets/js/main.js',
            [ 'jquery', 'jquery-ui-dialog' ],
            REMOTE_USERS_VERSION,
            true
        );
    }
}
