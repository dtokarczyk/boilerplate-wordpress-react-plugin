<?php

function display_flash_notices()
{
    $option_token = PLUGIN_NAME_SLUG . '_notice';

    $notices = get_option($option_token, []);

    foreach ($notices as $notice) {
        printf(
            '<div class="notice notice-%1$s %2$s"><p>%3$s</p></div>',
            $notice['type'],
            $notice['dismissible'],
            $notice['notice']
        );
    }

    if (!empty($notices)) {
        delete_option($option_token, []);
    }
}

add_action('admin_notices', 'display_flash_notices', 12);
