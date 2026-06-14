<?php
add_action( 'acf/init', 'techark_register_options_fields' );

function techark_register_options_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

    acf_add_local_field_group([
        'key'    => 'group_techark_options',
        'title'  => 'Theme Options Fields',
        'fields' => [

            // ── TAB: Colors ──────────────────────────────
            [
                'key'   => 'field_tab_colors',
                'label' => 'Colors',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_primary_color',
                'label'        => 'Primary Color',
                'name'         => 'primary_color',
                'type'         => 'color_picker',
                'default_value'=> '#0d6efd',
                'parent'       => 'group_techark_options',
            ],
            [
                'key'          => 'field_secondary_color',
                'label'        => 'Secondary Color',
                'name'         => 'secondary_color',
                'type'         => 'color_picker',
                'default_value'=> '#6c757d',
                'parent'       => 'group_techark_options',
            ],

            // ── TAB: Typography ──────────────────────────
            [
                'key'   => 'field_tab_typography',
                'label' => 'Typography',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_heading_font',
                'label'        => 'Heading Font Family',
                'name'         => 'heading_font',
                'type'         => 'text',
                'default_value'=> 'Inter, sans-serif',
                'parent'       => 'group_techark_options',
            ],
            [
                'key'          => 'field_body_font',
                'label'        => 'Body Font Family',
                'name'         => 'body_font',
                'type'         => 'text',
                'default_value'=> 'Inter, sans-serif',
                'parent'       => 'group_techark_options',
            ],
            [
                'key'          => 'field_base_font_size',
                'label'        => 'Base Font Size (px)',
                'name'         => 'base_font_size',
                'type'         => 'number',
                'default_value'=> 16,
                'parent'       => 'group_techark_options',
            ],

            // ── TAB: Buttons ─────────────────────────────
            [
                'key'   => 'field_tab_buttons',
                'label' => 'Buttons',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_btn_primary_bg',
                'label'        => 'Primary Button BG',
                'name'         => 'btn_primary_bg',
                'type'         => 'color_picker',
                'default_value'=> '#0d6efd',
                'parent'       => 'group_techark_options',
            ],
            [
                'key'          => 'field_btn_primary_text',
                'label'        => 'Primary Button Text Color',
                'name'         => 'btn_primary_text',
                'type'         => 'color_picker',
                'default_value'=> '#ffffff',
                'parent'       => 'group_techark_options',
            ],
            [
                'key'          => 'field_btn_border_radius',
                'label'        => 'Button Border Radius (px)',
                'name'         => 'btn_border_radius',
                'type'         => 'number',
                'default_value'=> 6,
                'parent'       => 'group_techark_options',
            ],

            // ── TAB: Header ──────────────────────────────
            [
                'key'   => 'field_tab_header',
                'label' => 'Header',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_header_bg_color',
                'label'        => 'Header Background Color',
                'name'         => 'header_bg_color',
                'type'         => 'color_picker',
                'default_value'=> '#ffffff',
                'parent'       => 'group_techark_options',
            ],
            [
                'key'          => 'field_sticky_header',
                'label'        => 'Sticky Header',
                'name'         => 'sticky_header',
                'type'         => 'true_false',
                'default_value'=> 1,
                'ui'           => 1,
                'parent'       => 'group_techark_options',
            ],

            // ── TAB: Footer ──────────────────────────────
            [
                'key'   => 'field_tab_footer',
                'label' => 'Footer',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_footer_bg_color',
                'label'        => 'Footer Background Color',
                'name'         => 'footer_bg_color',
                'type'         => 'color_picker',
                'default_value'=> '#212529',
                'parent'       => 'group_techark_options',
            ],
            [
                'key'          => 'field_footer_text_color',
                'label'        => 'Footer Text Color',
                'name'         => 'footer_text_color',
                'type'         => 'color_picker',
                'default_value'=> '#ffffff',
                'parent'       => 'group_techark_options',
            ],
            [
                'key'          => 'field_footer_copyright',
                'label'        => 'Copyright Text',
                'name'         => 'footer_copyright',
                'type'         => 'text',
                'default_value'=> '© 2025 Your Company',
                'parent'       => 'group_techark_options',
            ],

            // ── TAB: Social ──────────────────────────────
            [
                'key'   => 'field_tab_social',
                'label' => 'Social',
                'type'  => 'tab',
            ],
            [
                'key'    => 'field_social_facebook',
                'label'  => 'Facebook URL',
                'name'   => 'social_facebook',
                'type'   => 'url',
                'parent' => 'group_techark_options',
            ],
            [
                'key'    => 'field_social_instagram',
                'label'  => 'Instagram URL',
                'name'   => 'social_instagram',
                'type'   => 'url',
                'parent' => 'group_techark_options',
            ],
            [
                'key'    => 'field_social_linkedin',
                'label'  => 'LinkedIn URL',
                'name'   => 'social_linkedin',
                'type'   => 'url',
                'parent' => 'group_techark_options',
            ],
            [
                'key'    => 'field_social_twitter',
                'label'  => 'Twitter / X URL',
                'name'   => 'social_twitter',
                'type'   => 'url',
                'parent' => 'group_techark_options',
            ],

        ],
        'location' => [[
            [
                'param'    => 'options_page',
                'operator' => '==',
                'value'    => 'theme-options',
            ],
        ]],
    ]);
}