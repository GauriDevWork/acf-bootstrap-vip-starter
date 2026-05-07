<?php

/**
 * Custom Image layout
 *
 * @package {{THEME_PACKAGE}}
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Generate lazy-load image HTML safely
 */
function getlazyload_img($ImgArray = array(), $width = '', $height = '', $imgclass = '', $fetchpriority = '', $alt = '')
{
    // Validate $ImgArray
    if (!is_array($ImgArray)) {
        $ImgArray = array();
    }

    // Safely extract values with fallbacks
    $url = !empty($ImgArray['url']) ? $ImgArray['url'] : '';
    $title = !empty($ImgArray['title']) ? $ImgArray['title'] : '';

    if (!empty($alt)) {
        $final_alt = $alt;
    } elseif (!empty($ImgArray['alt'])) {
        $final_alt = $ImgArray['alt'].'-alt';
    } else {
        $final_alt = '';
    }

    $width = !empty($width) ? $width : (!empty($ImgArray['width']) ? $ImgArray['width'] : '');
    $height = !empty($height) ? $height : (!empty($ImgArray['height']) ? $ImgArray['height'] : '');

    // Normalize class list
    $imgclass_arr = array_filter(explode(' ', $imgclass));

    // Determine if fetchpriority attribute should be added
    $fetch_attr = !empty($fetchpriority) ? ' fetchpriority="' . esc_attr($fetchpriority) . '"' : '';

    // Handle no-lazyload
    if (in_array('no-lazyload', $imgclass_arr)) {
        $ImageTag = sprintf(
            '<img src="%s" class="%s" alt="%s" title="%s" width="%s" height="%s"%s>',
            esc_url($url),
            esc_attr(implode(' ', $imgclass_arr)),
            esc_attr($final_alt),
            esc_attr($title),
            esc_attr($width),
            esc_attr($height),
            $fetch_attr
        );

        // Handle custom-lazyload
    } elseif (in_array('custom-lazyload', $imgclass_arr)) {
        $placeholder = is_front_page() ? site_url('/wp-admin/images/spinner.gif') : 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
        $extra_class = is_front_page() ? ' loader-image' : '';

        $ImageTag = sprintf(
            '<img src="%s" data-src="%s" class="%s%s" alt="%s" title="%s" width="%s" height="%s">',
            esc_url($placeholder),
            esc_url($url),
            esc_attr(implode(' ', $imgclass_arr)),
            esc_attr($extra_class),
            esc_attr($final_alt),
            esc_attr($title),
            esc_attr($width),
            esc_attr($height)
        );

        // Default lazyload
    } else {
        $ImageTag = sprintf(
            '<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="%s" class="lazyload %s" alt="%s" title="%s" width="%s" height="%s"%s>',
            esc_url($url),
            esc_attr(implode(' ', $imgclass_arr)),
            esc_attr($final_alt),
            esc_attr($title),
            esc_attr($width),
            esc_attr($height),
            $fetch_attr
        );
    }

    return $ImageTag;
}
