# Remote users

## Plugin details
- Contributors: Vijayan G
- Tags: remote, interview
- Requires at least: 5.5
- Tested up to: 5.7
- Requires PHP: 7.3
- Stable tag: 0.1.0
- License: GPLv2 or later
- License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin is used to fetch the remote users through 3rd party API.

### Description
---

This plugin provides custom hooks, filters, translation ready (pot but not included json) for remote users table with event driven data fetching logic.

## Decisions
---
1. The custom url is `remote-users` therefore it will look like http://domain.tld/remote-users/
2. Used transient to store the API JSON response as an object, the reason behind this is transient support mixed data type
3. For error handling used `is_wp_error`
4. Used `wp_safe_remote_head` instead of `wp_remote_head`
5. Used `wp_safe_remote_get` instead of `wp_remote_get`
6. Fetched head then content to avoid overload for both requesting and responding servers
7. Transient's expiry is calculated directly using cache tags of header data for details see private method `setTransient` of class [Remote](inc/Utils/Remote.php#L70)
8. Didn't used `wp_ajax_nopriv` and `wp_ajax` hooks instead of that directly fetched in JS the reason is the data are publicly available so instead of abstract and show only necessary key-value directly fetched
9. Constants are place in their respective context instead of centralize it in common file (mostly I place all constants in an array instead of using const or define therefore using `wp_json_encode` and pass it to JS through the function [wp_add_inline_script](https://developer.wordpress.org/reference/functions/wp_add_inline_script/) )
10. Implemented deactivation hook to clear cache didn't used uninstall hook or file `uninstall.php` because not stored any persistent data
11. Added table data using hook mechanism and render partial
12. In JS click event ajax the data is not cached using local storage (if you like to do that please let me know)
13. Didn't focused in any UI enhancement (but verified in twentytwentyone the table was responsive and lagging of marging and padding but I can able to do that)
14. Note plugin boilerplate was done using wp-cli's plugin scaffold
15. For template passed data using global variable the reason is the argument passing is applicable in themes template only [Passing arguments to template files in WordPress 5.5](https://make.wordpress.org/core/2020/07/17/passing-arguments-to-template-files-in-wordpress-5-5/)
16. Followed the WP suggestion to support last two versions

## Installation
---
This section describes how to install the plugin and get it working.

e.g.

1. Git clone inside the directory `remote-users` to the `/wp-content/plugins/` directory
2. Do `composer update`
3. Activate the plugin through the 'Plugins' menu in WordPress

### Changelog

>0.1.0
* Fetches remote users.
* On click the anchor tag pops up user's contact info.

### Hooks

#### *Action*
1. `remote-users/template/before-main-content`
2. `remote-users/template/main-content`
3. `remote-users/template/after-main-content`

#### *Filter*
1. `remote-users/filter/page-title`

### Useful commands

| Context | Command |
|---------|---------|
| WP CLI -> Rewrite API | `wp rewrite list --match="remote-users"` |
| WP CLI -> Transient API | `wp transient get 'vg-remote-users'` |
| Composer | `composer update` |
| Coding Standard | `vendor/bin/phpcs --standard="Inpsyde" ./remote-users.php ./inc ./templates` |
| Coding Beautifier | `vendor/bin/phpcbf --standard="Inpsyde" ./remote-users.php ./inc ./templates` |
| Testing -> Unit Testing | `vendor/bin/phpunit` |