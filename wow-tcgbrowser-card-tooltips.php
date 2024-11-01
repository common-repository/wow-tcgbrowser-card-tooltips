<?php
/*
Plugin Name: WoW TCGBrowser Card Tooltips
Plugin URI: http://wordpress.org/plugins/wow-tcgbrowser-card-tooltips/
Description: Transform WoW TCG card names into links that show the card image when hovering over them.
Author: bogycoins
Version: 1.0
*/


function wow_tcgbrowser_register_button($buttons) {
    array_push($buttons, "separator", "wow_tcgbrowser");
    return $buttons;
}

function wow_tcgbrowser_add_tinymce_plugin($plugin_array) {
    $plugin_array['wow_tcgbrowser'] = get_bloginfo('wpurl') . '/wp-content/plugins/wow-tcgbrowser-card-tooltips/resources/tinymce3/editor_plugin.js';
    return $plugin_array;
}

function wow_tcgbrowser_add_buttons() {
    wp_enqueue_script('wow_tcgbrowser', 'http://wow.tcgbrowser.com/tools/api/tooltip.js', array('jquery'));

    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) return;

    // Add only in Rich Editor mode
    if (get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "wow_tcgbrowser_add_tinymce_plugin");
        add_filter('mce_buttons', 'wow_tcgbrowser_register_button');
    }
}

add_action('init', 'wow_tcgbrowser_add_buttons');
