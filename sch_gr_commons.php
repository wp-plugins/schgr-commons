<?php

/*
  Plugin Name: Sch.gr commons
  Plugin URI:
  Description:  Adds oEmbed support in WordPress posts, pages and custom post types for videos, presentations etc from the vod-new.sch.gr, mmpres.sch.gr sites of Greek Schools Network.
  Tags: sch.gr, vod-new.sch.gr, mmpres.sch.gr
  Version: 1.0
  Requires at least: WordPress  3.5
  Tested up to: WordPress 4.2.2
  Author:  NTS on CTI.gr, lenasterg
  Author URI:
  Text Domain: sch_gr_commons
  Domain Path: /languages/
  License: GNU/GPL 3
 */

add_action('plugins_loaded', 'sch_gr_commons_i18n_init');

/**
 * Initialize internationalization (i18n) for this plugin.
 * References:
 *      http://codex.wordpress.org/I18n_for_WordPress_Developers
 *      http://www.wdmac.com/how-to-create-a-po-language-translation#more-631
 * @since 1.0
 */
function sch_gr_commons_i18n_init() {
    load_plugin_textdomain('sch_gr_commons', false, basename(dirname(__FILE__)) . '/languages/');
}

/**
 * Add mmpress.sch.gr support
 * @since 1.0
 */
wp_embed_register_handler('mmpressch', '/mmpres.sch.gr:4000\/(\w+)/i', 'sch_gr_wp_embed_handler_mmpressch');

function sch_gr_wp_embed_handler_mmpressch($matches, $attr, $url, $rawattr) {
    $args = wp_parse_args($args, wp_embed_defaults());

    $width = $args['width'];
    $height = floor($width * 402 / 485);
    $embed = '<div align="center"><iframe allowtransparency="true" width="' . $width . '" height="' . $height . '" src="' . $url . '/?autostart=false" frameborder="0" allowfullscreen mozallowfullscreen="" webkitallowfullscreen=""></iframe>'
            . '	<br/><a href="http://mmpres.sch.gr">' . __('Go to mmpres.sch.gr', 'sch_gr_commons') . '</a></div>';

    return apply_filters('sch_gr_embed_mmpressch', $embed, $matches, $attr, $url, $rawattr);
}

wp_embed_register_handler('vodnew', '/http:\/\/vod-new.sch.gr\/asset\/detail\/((\w+)\/(\w+))/', 'sch_gr_wp_embed_handler_vodnew');

/**
 * Add mmpress.sch.gr support
 * @since 1.0
 */
function sch_gr_wp_embed_handler_vodnew($matches, $attr, $url, $rawattr) {
    $args = wp_parse_args($args, wp_embed_defaults());

    $width = $args['width'];
    $height = floor($width * 260 / 450);
    $embed = '<div align="center"><iframe src="' . sprintf(
                    'http://vod-new.sch.gr/asset/player/%1$s/%2$s', esc_attr($matches[1]), esc_attr($matches[2])) . '" width="' . $width . 'px" '
            . 'height="' . $height . 'px" scrolling="no" frameborder="0" '
            . 'allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen=""></iframe>'
            . '<br/><a href="' . $url . '">' . __('Watch it in vod-new.sch.gr', 'sch_gr_commons') . '</a></div>';
    ;

    return apply_filters('sch_gr_wp_embed_vodnew', $embed, $matches, $attr, $url, $rawattr);
}
