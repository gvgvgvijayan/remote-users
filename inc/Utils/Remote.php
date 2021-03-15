<?php

/**
 * Handles 3rd party API.
 */

declare(strict_types=1);

namespace Remote_Users\Utils;

/**
 * Class to handle 3rd part API.
 */
class Remote
{

    /**
     * 3rd party endpoint URL.
     */
    private const ENDPOINT = 'https://jsonplaceholder.typicode.com/users/';

    /**
     * Transient key.
     */
    private const TRANS_KEY = 'vg-remote-users';

    /**
     * Users list.
     *
     * Return the users list with success flag.
     *
     * @return array Users list.
     */
    public function users(): array
    {
        $users = get_transient(self::TRANS_KEY) ?: $this->fetchUsersApi();

        return $users;
    }

    /**
     * Transient key.
     *
     * Return the transient key.
     *
     * @return string Transient key.
     */
    public function transKey(): string
    {
        return self::TRANS_KEY;
    }

    /**
     * Build users list.
     *
     * Fetches users from 3rd party.
     *
     * @return array Users list with success flag.
     */
    private function fetchUsersApi(): array
    {
        $data = [ 'users' => [], 'is_success' => false ];

        $headResponse = wp_safe_remote_head(self::ENDPOINT);
        $remainingLimit = wp_remote_retrieve_header(
            $headResponse,
            'x-ratelimit-remaining'
        );

        /*
         * Fetch header before getting body to check quota availability.
         */
        if (
            200 === wp_remote_retrieve_response_code($headResponse) &&
            (int) $remainingLimit > 0
        ) {
            $getResponse = wp_safe_remote_get(self::ENDPOINT);

            if (! is_wp_error($getResponse)) {
                $data['is_success'] = true;
            }

            if (200 === wp_remote_retrieve_response_code($getResponse)) {
                $getAge = (int) wp_remote_retrieve_header(
                    $headResponse,
                    'age'
                );

                $getCacheCtl = wp_remote_retrieve_header(
                    $headResponse,
                    'cache-control'
                );

                $usersJsonStr = wp_remote_retrieve_body($getResponse);
                $data['users'] = json_decode($usersJsonStr);

                $this->setTransient($data, $getCacheCtl, $getAge);
            }
        }

        return $data;
    }

    /**
     * Set transient.
     *
     * Set transient by calculating expires time using header cache tags.
     *
     * @param array $data Data i.e. users list to be stored
     * @param string $cacheCtl String extracted from cache control.
     * @param int $age Age of the cached request in seconds.
     *
     * @return void
     */
    private function setTransient(array $data, string $cacheCtl, int $age): void
    {
        $timeRemaining = HOUR_IN_SECONDS; //Default transient expiry.

        $reg = '/max-age=(\d+)/';
        preg_match($reg, $cacheCtl, $getMaxAge);

        $diffTime = (int) $getMaxAge[1] - (int)  $age;

        if (
            isset($getMaxAge[1]) &&
            $diffTime > 0
        ) {
            $timeRemaining = $diffTime;
        }

        set_transient(self::TRANS_KEY, $data, $timeRemaining);
    }
}
