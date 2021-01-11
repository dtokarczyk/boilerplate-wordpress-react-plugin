<?php

function make_admin_notice(
    string $notice = '',
    string $type = 'warning',
    bool $dismissible = true
): void {
    $option_token = PLUGIN_NAME_SLUG . '_notice';
    $notices = get_option($option_token, []);

    $dismissible_text = $dismissible ? "is-dismissible" : "";

    array_push($notices, [
        "notice" => $notice,
        "type" => $type,
        "dismissible" => $dismissible_text,
    ]);

    update_option($option_token, $notices);
}
