<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package {{THEME_PACKAGE}}
 */

get_header();

$options = get_option('{{THEME_PREFIX}}options');

$post_id = get_the_ID();

?>
<main id="main-content" class="site-main">
  <?php
  get_template_part('custom-templates/header-banner', null);
  ?>
  <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>  py-75">
    <div class="{{THEME_PREFIX}}-blog-row blog-detail">
      <?php
      if ($options['single_sidebar_position'] == 'left-sidebar') {
      ?>
        <div class="{{THEME_PREFIX}}-blog-sidebar">
          <?php
          if (is_active_sidebar('blog-sidebar')):
            dynamic_sidebar('blog-sidebar');
          endif;
          ?>
        </div>
      <?php
      }
      ?>
      <div class="{{THEME_PREFIX}}-blog-card-wrapper">
        <div class="{{THEME_PREFIX}}-blog-card-row">
          <?php
          if (has_post_thumbnail()):
          ?>
            <div class="post-thumbnail">
              <?php

              $url = get_the_post_thumbnail_url($post_id, 'full');

              $thumb_id_main   = get_post_thumbnail_id($post_id);
              $image_alt_main  = !empty($thumb_id_main) ? get_post_meta($thumb_id_main, '_wp_attachment_image_alt', true) :   get_the_title($post_id) . '-alt';

              $image_arr = array(
                'url' => $url,
                'alt' => $image_alt_main,
                'title' => get_the_title($post_id)
              );

              echo getlazyload_img($image_arr, '100', '100');

              ?>
            </div>
          <?php
          endif;

          $meta_display = !empty($options['single_post_meta_display']) ? $options['single_post_meta_display'] : [];

          if (!empty($meta_display)): ?>
            <div class="post-meta">
              <?php
              if (in_array('date', $meta_display)):
              ?>
                <span class="post-date">
                  <?php
                  echo esc_html(get_the_date());
                  ?>
                </span>
              <?php
              endif;
              if (in_array('author', $meta_display)):
              ?>
                <span class="post-author">by
                  <?php
                  $author_id   = get_post_field('post_author', get_the_ID());
                  $author_name = get_the_author_meta('display_name', $author_id);

                  echo esc_html($author_name);
                  ?>
                </span>
              <?php
              endif;
              if (in_array('category', $meta_display)):
              ?>
                <span class="post-categories"><?php the_category(', '); ?></span>
              <?php
              endif;
              ?>
            </div>
            <?php
            if (in_array('tags', $meta_display)):
            ?>
              <div class="post-tags">
                <?php the_tags('<strong>Tags: </strong>', ', '); ?>
              </div>
            <?php
            endif;
            ?>
          <?php endif;

          if (!empty(get_the_content())) {
          ?>
            <div class="post-content">
              <?php
              the_content();
              ?>
            </div>
          <?php
          }

          $post_url   = urlencode(get_permalink());
          $post_title = urlencode(get_the_title());

          $share_buttons = $options['share_buttons'];

          $button_names = array(
            'fb-link'        => 'Facebook',
            'instagram-link' => 'Instagram',
            'linkedin-icon'  => 'LinkedIn',
            'whatsapp-icon'  => 'WhatsApp',
            'twitter-icon'   => 'Twitter',
            'tiktok-icon'    => 'TikTok',
          );

          // Generate dynamic share URLs
          $button_share_url = array(
            'fb-link'        => 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url,
            'linkedin-icon'  => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $post_url,
            'whatsapp-icon'  => 'https://api.whatsapp.com/send?text=' . $post_title . '%20' . $post_url,
            'twitter-icon'   => 'https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . $post_title,
          );

          // Only keep enabled buttons
          $active_buttons = array_filter($share_buttons, function ($value) {
            return $value == 1;
          });

          if (!empty($active_buttons)) { ?>
            <div class="share-buttons">
              <p>Share it:</p>
              <ul>
                <?php foreach ($active_buttons as $key => $value): ?>
                  <li>
                    <a href="<?php echo esc_url($button_share_url[$key]); ?>" target="_blank" class="<?php echo esc_attr($key); ?>">
                      <?php echo isset($button_names[$key]) ? esc_html($button_names[$key]) : esc_html($key); ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php
          }

          ?>

        </div>
      </div>
      <?php
      if ($options['single_sidebar_position'] == 'right-sidebar') {
      ?>
        <div class="{{THEME_PREFIX}}-blog-sidebar">
          <?php
          if (is_active_sidebar('blog-sidebar')):
            dynamic_sidebar('blog-sidebar');
          endif;
          ?>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
  <?php
  if ($options['related_posts']) {

    $related_by = !empty($options['related_posts_by']) ? $options['related_posts_by'] : 'category';

    $args = array(
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'order'          => 'DESC',
      'posts_per_page' => (int) $options['related_posts_count'],
      'post__not_in'   => array($post_id),
    );

    if ($related_by === 'category') {
      $categories = wp_get_post_categories($post_id);
      if (!empty($categories)) {
        $args['category__in'] = $categories;
      }
    } elseif ($related_by === 'tag') {
      $tags = wp_get_post_tags($post_id);
      if (!empty($tags)) {
        $tag_ids = wp_list_pluck($tags, 'term_id');
        $args['tag__in'] = $tag_ids;
      }
    }

    $related_query = new WP_Query($args);

    if ($related_query->have_posts()) {
  ?>
      <section class="{{THEME_PREFIX}}-rp py-75">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
          <?php
          if (!empty($options['related_title'])) {
          ?>
            <h2 class="h2"><?php echo esc_html($options['related_title']); ?></h2>
          <?php
          }

          $post_count = $related_query->post_count;
          ?>
          <div class="{{THEME_PREFIX}}-rp-slider-wrapper">
            <div class="{{THEME_PREFIX}}-rp-slider owl-carousel owl-theme" post_count="<?php echo $post_count; ?>">
              <?php
              while ($related_query->have_posts()):
                $related_query->the_post();
                $related_id = get_the_ID();
                $content = esc_html({{THEME_PREFIX}}get_excerpt_or_content(50, $related_id));
              ?>
                <div class="item">
                  <div class="{{THEME_PREFIX}}-blog-card">
                    <a href="<?php echo esc_url(get_permalink($related_id)); ?>" class="img-block">
                      <?php
                      $url = !empty(get_the_post_thumbnail_url($related_id, 'full')) ? get_the_post_thumbnail_url($related_id, 'full') : $options['placeholder_image']['url'];

                      $thumb_id   = get_post_thumbnail_id($related_id);
                      $image_alt  = !empty($thumb_id) ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) :   get_the_title($related_id) . '-alt';


                      $image_arr = array(
                        'url' => $url,
                        'alt' => $image_alt,
                        'title' => get_the_title($related_id)
                      );

                      echo getlazyload_img($image_arr, '100', '100');

                      if (!empty($options['related_post_meta_display']) && in_array('date', $options['related_post_meta_display'])) {
                      ?>
                        <span class="post_date">
                          <span><?php echo esc_html(get_the_date('d', $related_id)); ?></span>
                          <?php echo esc_html(get_the_date('M', $related_id)); ?>
                        </span>
                      <?php
                      }
                      ?>
                    </a>
                    <div class="content-block">
                      <?php
                      if (!empty($options['related_post_meta_display']) && in_array('category', $options['related_post_meta_display'])) {
                        $related_categories = get_the_category($related_id);
                        if ($related_categories) {
                      ?>
                          <div class="categories">
                            <?php
                            $category_links = array();
                            foreach ($related_categories as $category) {
                              $category_links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="h6">' . esc_html($category->name) . '</a>';
                            }
                            echo implode(", ", $category_links);
                            ?>
                          </div>
                      <?php
                        }
                      }
                      ?>
                      <a href="<?php echo esc_url(get_permalink($related_id)); ?>" class="h3">
                        <?php echo esc_html(get_the_title($related_id)); ?>
                      </a>
                      <?php if ($content) {
                      ?>
                        <p><?php echo $content; ?></p>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
        </div>
      </section>
  <?php

    }
    wp_reset_postdata();
  }
  ?>
</main>
<?php

get_footer();
