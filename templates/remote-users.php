<?php

/**
 * The Template for displaying remote users page
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

get_header();

/**
 * Hook to display before main page content
 */
do_action('remote-users/template/before-main-content');

/**
 * Hook to display main page content
 */
do_action('remote-users/template/main-content');

/**
 * Hook to display after main page content
 */
do_action('remote-users/template/after-main-content');

get_footer();
