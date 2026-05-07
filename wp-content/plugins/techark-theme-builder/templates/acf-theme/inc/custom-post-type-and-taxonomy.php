<?php

/**
 * US Heart and Vascular modify editor
 *
 * @package US_Heart_and_Vascular
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/* Team */

// Add custom columns to Team post type
add_filter('manage_team_posts_columns', '{{THEME_PREFIX}}add_team_columns');
function {{THEME_PREFIX}}add_team_columns($columns)
{
    // Remove default date column for reordering
    unset($columns['date']);

    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __('Name', '{{TEXT_DOMAIN}}');
    $new_columns['profile_image'] = __('Profile Image', '{{TEXT_DOMAIN}}');
    $new_columns['bio'] = __('Bio', '{{TEXT_DOMAIN}}');
    $new_columns['position'] = __('Member Position', '{{TEXT_DOMAIN}}');
    $new_columns['linkedin_url'] = __('LinkedIn URL', '{{TEXT_DOMAIN}}');
    $new_columns['category'] = __('Category', '{{TEXT_DOMAIN}}');
    $new_columns['date'] = __('Date', '{{TEXT_DOMAIN}}');
    return $new_columns;
}

// Populate custom column data
add_action('manage_team_posts_custom_column', '{{THEME_PREFIX}}team_custom_column_data', 10, 2);
function {{THEME_PREFIX}}team_custom_column_data($column, $post_id)
{
    switch ($column) {

        case 'profile_image':
            if (has_post_thumbnail($post_id)) {
                $edit_link = get_edit_post_link($post_id);
                echo '<a href="' . esc_url($edit_link) . '">';
                echo get_the_post_thumbnail($post_id, 'thumbnail', array(
                    'style' => 'width:60px;height:60px;border-radius:6px;object-fit:cover;',
                    'alt' => esc_attr(get_the_title($post_id)),
                ));
                echo '</a>';
            } else {
                echo '<em>No image</em>';
            }
            break;

        case 'bio':
            $content = get_the_content(null, false, $post_id);
            $trimmed = wp_trim_words(strip_tags($content), 20, '...');
            echo esc_html($trimmed);
            break;

        case 'position':
            $position = get_field('position', $post_id);
            if (!empty($position)) {
                echo esc_html($position);
            } else {
                echo '<em>—</em>';
            }
            break;

        case 'linkedin_url':
            $linkedin = get_field('linkedin_url', $post_id);
            if (!empty($linkedin)) {
                echo '<a href="' . esc_url($linkedin) . '" target="_blank" 
                 title="View LinkedIn Profile"
                 style="text-decoration:none;">
                 <span class="dashicons dashicons-linkedin" 
                       style="font-size:20px;color:#0077b5;">
                 </span>
              </a>';
            } else {
                echo '<em>—</em>';
            }
            break;
        case 'category':
            $terms = get_the_terms($post_id, 'member-category');
            if (!empty($terms) && !is_wp_error($terms)) {
                $term_names = wp_list_pluck($terms, 'name');
                echo esc_html(implode(', ', $term_names));
            } else {
                echo '<em>—</em>';
            }
            break;
    }
}

// Make columns sortable (optional)
add_filter('manage_edit-team_sortable_columns', '{{THEME_PREFIX}}team_sortable_columns');
function {{THEME_PREFIX}}team_sortable_columns($columns)
{
    $columns['title'] = 'title';
    $columns['date'] = 'date';
    return $columns;
}

/* Post */

// Add custom columns to default Posts
add_filter('manage_post_posts_columns', '{{THEME_PREFIX}}add_post_columns');
function {{THEME_PREFIX}}add_post_columns($columns)
{
    // Rebuild the order of columns manually
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumbnail'] = __('Thumb Image', '{{TEXT_DOMAIN}}');
    $new_columns['title'] = __('Title', '{{TEXT_DOMAIN}}');
    $new_columns['author'] = __('Author', '{{TEXT_DOMAIN}}');
    $new_columns['categories'] = __('Categories', '{{TEXT_DOMAIN}}');
    $new_columns['tags'] = __('Tags', '{{TEXT_DOMAIN}}');
    $new_columns['date'] = __('Date', '{{TEXT_DOMAIN}}');
    return $new_columns;
}

// Populate data for custom columns
add_action('manage_post_posts_custom_column', '{{THEME_PREFIX}}post_custom_column_data', 10, 2);
function {{THEME_PREFIX}}post_custom_column_data($column, $post_id)
{
    switch ($column) {

        case 'thumbnail':
            if (has_post_thumbnail($post_id)) {
                $edit_link = get_edit_post_link($post_id);
                echo '<a href="' . esc_url($edit_link) . '">';
                echo get_the_post_thumbnail($post_id, 'thumbnail', array(
                    'style' => 'width:60px;height:60px;object-fit:cover;border-radius:6px;',
                    'alt' => esc_attr(get_the_title($post_id)),
                ));
                echo '</a>';
            } else {
                echo '<em>No image</em>';
            }
            break;

        case 'categories':
            $categories = get_the_category($post_id);
            if (!empty($categories)) {
                echo esc_html(implode(', ', wp_list_pluck($categories, 'name')));
            } else {
                echo '<em>—</em>';
            }
            break;

        case 'tags':
            $tags = get_the_tags($post_id);
            if (!empty($tags)) {
                echo esc_html(implode(', ', wp_list_pluck($tags, 'name')));
            } else {
                echo '<em>—</em>';
            }
            break;
    }
}

// Optional: Make some columns sortable
add_filter('manage_edit-post_sortable_columns', '{{THEME_PREFIX}}post_sortable_columns');
function {{THEME_PREFIX}}post_sortable_columns($columns)
{
    $columns['title'] = 'title';
    $columns['author'] = 'author';
    $columns['date'] = 'date';
    return $columns;
}

/* Physicians */
// Add Designation + Thumbnail columns
add_filter('manage_physicians_posts_columns', function ($columns) {

    $new = [];

    foreach ($columns as $key => $label) {
        $new[$key] = $label;

        if ($key === 'title') {
            $new['physician_thumbnail'] = __('Thumbnail', '{{TEXT_DOMAIN}}');
            $new['designation'] = __('Designation', '{{TEXT_DOMAIN}}');
        }
    }

    return $new;
});


// Fill column data
add_action('manage_physicians_posts_custom_column', function ($column, $post_id) {

    // Thumbnail column
    if ($column === 'physician_thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail(
                $post_id,
                [60, 60],
                ['style' => 'max-width:60px;height:auto;']
            );
        } else {
            echo '<em>—</em>';
        }
    }

    // Designation column
    if ($column === 'designation') {
        $designation = get_post_meta($post_id, 'designation', true);
        echo !empty($designation) ? esc_html($designation) : '<em>—</em>';
    }

}, 10, 2);


// Make Designation sortable
add_filter('manage_edit-physicians_sortable_columns', function ($columns) {
    $columns['designation'] = 'designation';
    return $columns;
});


// Handle sorting by Designation meta
add_action('pre_get_posts', function ($query) {

    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('orderby') === 'designation') {
        $query->set('meta_key', 'designation');
        $query->set('orderby', 'meta_value');
    }

});

/* Testimonials */

// Add new columns
add_filter('manage_testimonials_posts_columns', function ($columns) {

    $new = [];

    foreach ($columns as $key => $label) {
        $new[$key] = $label;

        // Insert after Title
        if ($key === 'title') {
            $new['author_name'] = __('Author Name', '{{TEXT_DOMAIN}}');
            $new['testimonial_thumbnail'] = __('Thumbnail', '{{TEXT_DOMAIN}}');
            $new['rating'] = __('Rating', '{{TEXT_DOMAIN}}');
        }
    }

    return $new;
});


// Fill columns
add_action('manage_testimonials_posts_custom_column', function ($column, $post_id) {

    if ($column === 'author_name') {
        echo get_post_meta($post_id, 'author_name', true);
    }

    // Thumbnail column
    if ($column === 'testimonial_thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail(
                $post_id,
                [60, 60],
                [
                    'style' => 'max-width:60px;height:auto;',
                    'alt' => esc_attr(get_the_title($post_id)),
                ]
            );
        } else {
            echo '<em>—</em>';
        }
    }

    // Rating column
    if ($column === 'rating') {
        $rating = get_post_meta($post_id, 'rating', true);
        echo !empty($rating) ? str_repeat('⭐', (int) $rating) : '<em>—</em>';
    }

}, 10, 2);


// Make Rating sortable
add_filter('manage_edit-testimonials_sortable_columns', function ($columns) {
    $columns['rating'] = 'rating';
    return $columns;
});


// Handle sorting by Rating
add_action('pre_get_posts', function ($query) {

    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('orderby') === 'rating') {
        $query->set('meta_key', 'rating');
        $query->set('orderby', 'meta_value_num');
    }
});

/* Pages */

// Add a new column for Page Template
function add_page_template_column($columns)
{
    $columns['page_template'] = __('Page Template', 'US_Heart_and_Vascular');
    return $columns;
}
add_filter('manage_pages_columns', 'add_page_template_column');


// Populate the column with the Page Template Name
function display_page_template_column($column_name, $post_id)
{
    if ($column_name == 'page_template') {
        $template = get_page_template_slug($post_id);


        if (!$template) {
            echo 'Default Template';
        } else {
            // Convert template filename to a readable format
            $templates = wp_get_theme()->get_page_templates();
            $template_name = array_search($template, $templates);
            echo $template_name ? $template_name : basename($template);
        }
    }
}
add_action('manage_pages_custom_column', 'display_page_template_column', 10, 2);

/* Services */

/**
 * Add Thumbnail column to Services CPT
 */
add_filter('manage_services_posts_columns', function ($columns) {

    $new = [];

    foreach ($columns as $key => $label) {
        $new[$key] = $label;

        // Insert after title
        if ($key === 'title') {
            $new['service_thumbnail'] = __('Thumbnail', '{{TEXT_DOMAIN}}');
        }
    }

    return $new;
});


/**
 * Render Thumbnail column content
 */
add_action('manage_services_posts_custom_column', function ($column, $post_id) {

    if ($column === 'service_thumbnail') {

        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail(
                $post_id,
                [60, 60],
                [
                    'style' => 'max-width:60px;height:auto;',
                    'alt' => esc_attr(get_the_title($post_id)),
                ]
            );
        } else {
            echo '<em>—</em>';
        }
    }

}, 10, 2);
