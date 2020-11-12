<?php

/*
Plugin Name: My Application
Description: Desc
Version: 1.0
Author: Damian Tokarczyk
Author URI: https://bively.pl
License: Business
*/

define('PLUGIN_VERSION', '1.0.0');
define('PLUGIN_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_NAME', 'MyApp'); // without spaces
define('PLUGIN_NAME_SLUG', 'my-app'); // without spaces
define('DEV_MODE', true);


if(DEV_MODE) {
    error_reporting(-1);
    ini_set('display_errors', 'On');
}


add_action('wp_enqueue_scripts', function () {
    $manifest = file_get_contents(
        PLUGIN_PLUGIN_URL . 'front-end/build/asset-manifest.json'
    );
    $manifest = (array) json_decode($manifest);
    $files = (array) $manifest['entrypoints'];
    
    wp_register_script(
        PLUGIN_NAME_SLUG . '-1',
        PLUGIN_PLUGIN_URL . 'front-end/build/' . $files[0],
        "",
        PLUGIN_VERSION,
        true
    );
    wp_register_script(
        PLUGIN_NAME_SLUG . '-2',
        PLUGIN_PLUGIN_URL . 'front-end/build/' . $files[1],
        "",
        PLUGIN_VERSION,
        true
    );
    wp_register_script(
        PLUGIN_NAME_SLUG . '-3',
        PLUGIN_PLUGIN_URL . 'front-end/build/' . $files[2],
        "",
        PLUGIN_VERSION,
        true
    );
    wp_enqueue_script(PLUGIN_NAME_SLUG . '-1');
    wp_enqueue_script(PLUGIN_NAME_SLUG . '-2');
    wp_enqueue_script(PLUGIN_NAME_SLUG . '-3');

    wp_register_style(
        PLUGIN_NAME_SLUG . '-4',
        PLUGIN_PLUGIN_URL . 'front-end/build/' . $files[2],
        "",
        PLUGIN_VERSION,
        true
    );
    wp_enqueue_style(PLUGIN_NAME_SLUG . '-4');
});


/**
 * Shortcode
 */
add_shortcode(PLUGIN_NAME_SLUG . '-app', function ($args) {
    return '<div id="'. PLUGIN_NAME_SLUG .'-root" data-userid="' .
        get_current_user_id() .
        '" data-wpnonce="' .
        wp_create_nonce(PLUGIN_NAME_SLUG) .
        '"></div>';
});

/**
 * Endpoints
 */

add_action('rest_api_init', function () {
    register_rest_route( PLUGIN_NAME_SLUG . '/v1', '/something', [
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) {
            return wp_send_json([]);
        },
    ]);
});