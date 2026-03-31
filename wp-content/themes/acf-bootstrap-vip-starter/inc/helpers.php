<?php

function acf_vip_button($button, $class = 'btn btn-primary') {

    if (empty($button) || empty($button['url'])) return;

    $url    = esc_url($button['url']);
    $title  = esc_html($button['title']);
    $target = !empty($button['target']) ? esc_attr($button['target']) : '_self';

    echo "<a href='{$url}' target='{$target}' class='{$class}' aria-label='{$title}'>{$title}</a>";
}

function acf_vip_image($image, $class = 'img-fluid', $size = 'full') {

    if (empty($image)) return;

    echo wp_get_attachment_image(
        $image['ID'],
        $size,
        false,
        [
            'class'   => $class,
            'loading' => 'lazy'
        ]
    );
}

function acf_vip_text_align($align = 'left') {
    return ($align === 'center') ? 'text-center' : 'text-start';
}

function acf_vip_section_classes($bg = 'light', $spacing = true) {

    $classes = '';

    $bg_map = [
        'light'     => 'bg-light',
        'dark'      => 'bg-dark text-white',
        'primary'   => 'bg-primary text-white',
        'secondary' => 'bg-secondary text-white',
    ];

    $classes .= $bg_map[$bg] ?? 'bg-light';
    $classes .= ($spacing) ? ' py-5' : '';

    return $classes;
}
