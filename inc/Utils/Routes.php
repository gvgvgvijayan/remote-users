<?php

/**
 * Handle URL routing.
 */

declare(strict_types=1);

namespace Remote_Users\Utils;

/**
 * Class responsible for URL routing.
 */
class Routes
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
    public static function rewriteHooks(): void
    {
        $routes = new self();

        add_action('init', [ $routes, 'addCustomUrl' ]);
        add_filter('query_vars', [ $routes, 'addQueryKey' ]);
        add_filter('template_include', [ $routes, 'renderVirtualPage' ]);
    }

    /**
     * Custom URL.
     *
     * Add the rewrite rule.
     *
     * @return void
     */
    public function addCustomUrl(): void
    {
        //wp rewrite list --match="remote-users"
        add_rewrite_rule('remote-users$', 'index.php?r-users=1', 'top');
    }

    /**
     * Add query key.
     *
     * Push query key into the query variable array.
     *
     * @param array $queryVars Array of query keys.
     *
     * @return array $queryVars Array of query keys after added our custom key.
     */
    public function addQueryKey(array $queryVars): array
    {
        $queryVars[] = 'r-users';
        return $queryVars;
    }

    /**
     * Virtual page path.
     *
     * Prioritize the template rendering and switches the path.
     *
     * @param string $template Template filepath.
     *
     * @return string $template Template filepath.
     */
    public function renderVirtualPage(string $template): string
    {
        if (intval(get_query_var('r-users'))) {
            $fileName = 'remote-users.php';
            $template = REMOTE_USERS_PLUGIN_DIR . 'templates/' . $fileName;

            if (locate_template($fileName)) {
                $template = locate_template($fileName);
            }
        }

        return $template;
    }
}
