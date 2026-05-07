<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package {{THEME_PACKAGE}}
 */

get_header();

$options = get_option('{{THEME_PREFIX}}options');

$layout = !empty($options['category_post_layout']) ? $options['category_post_layout'] : 'grid';

$class = ($layout === 'list') ? 'list-view' : '';

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>
<main id="main-content" class="site-main">
	<?php
	get_template_part('custom-templates/header-banner', null);
	?>
	<section class="{{TEXT_DOMAIN}}-blog py-75">
		<div class="container">
			<div class="{{TEXT_DOMAIN}}-blog-row">
				<?php
				if ($options['category_sidebar_position'] == 'left-sidebar') {
				?>
					<div class="{{TEXT_DOMAIN}}-blog-sidebar">
						<?php
						if (is_active_sidebar('blog-sidebar')):
							dynamic_sidebar('blog-sidebar');
						endif;
						?>
					</div>
				<?php
				}

				$cat       = get_queried_object();
				$cat_id     = $cat->cat_ID;
				$cat_name   = $cat->name;

				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'cat' => $cat_id,
					'order' => 'DESC',
					'paged' => $paged
				);

				$one = new WP_Query($args);

				if ($one->have_posts()) :

				?>
					<div class="{{TEXT_DOMAIN}}-blog-card-wrapper">
						<div class="{{TEXT_DOMAIN}}-blog-card-row <?php echo $class;  ?>">
							<?php
							while ($one->have_posts()) : $one->the_post();

								$post_id = get_the_ID();

								$categories = get_the_category($post_id);

								$url = !empty(get_the_post_thumbnail_url($post_id, 'full')) ? get_the_post_thumbnail_url($post_id, 'full') : $options['placeholder_image']['url'];

								$thumb_id   = get_post_thumbnail_id($post_id);
								$image_alt  = !empty($thumb_id) ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) :   get_the_title($post_id) . '-alt';

								$image_arr = array(
									'url' => $url,
									'alt' => $image_alt,
									'title' => get_the_title($post_id)
								);

								$content = esc_html({{THEME_PREFIX}}get_excerpt_or_content(50));

							?>
								<a class="{{TEXT_DOMAIN}}-blog-card" href="<?php echo get_permalink($post_id); ?>">
									<div class="img-block">
										<?php
										echo getlazyload_img($image_arr, '100', '100');
										if ($options['enable_date_category']) {
										?>
											<span class="post_date">
												<span><?php echo esc_html(get_the_date('d')); ?></span>
												<?php echo esc_html(get_the_date('M')); ?>
											</span>
										<?php
										}
										?>
									</div>
									<div class="content-block">
										<div class="h3"><?php echo get_the_title($post_id); ?></div>
										<?php
										if ($content) {
										?>
											<p><?php echo $content; ?></p>
										<?php
										}
										?>
									</div>
								</a>
							<?php
							endwhile;
							?>
						</div>
						<nav aria-label="Page navigation">
							<?php
							$big = 999999999;
							$total = $one->max_num_pages;

							if ($total > 1) {
								if (!$current_page = $paged)
									$current_page = 1;

								$pages = paginate_links(array(
									/* 'base' => get_pagenum_link(1) . '%_%',
									'format' => 'page/%#%/', */
									'current' => max(1, $paged),
									'total' => $total,
									'mid_size' => 1,
									'type' => 'array',
									'prev_next' => true,
									'prev_text'          => __('<span class="icon-arrow"></span><b class="fs-0">Previous</b>'),
									'next_text'          => __('<span class="icon-arrow"></span><b class="fs-0">Next</b>'),
								));

								if (is_array($pages)) {
									echo '<ul class="pagination justify-content-center mb-0 wow fadeInUp">';
									foreach ($pages as $page) {
										$current = '';
										$dots = '';

										if (strpos($page, 'current') !== false) {
											$current = 'active';
										}

										if (strpos($page, 'dots') !== false) {
											$dots = 'pages-group';
										}

										$page = str_replace('page-numbers', 'page-link', $page);
										$page = str_replace('current', '', $page);
										$page = str_replace('dots', '', $page);
										$page = str_replace("aria='page'", '', $page);
										$page = str_replace('aria-="page"', '', $page);
										echo "<li class='page-item $current $dots' >$page</li>";
									}
									echo '</ul>';
								}
							}
							?>
						</nav>
					</div>
				<?php
				else:
				?>
					<div class="{{TEXT_DOMAIN}}-blog-card-wrapper">
						<div class='text-center'>No posts was found!</div>
					</div>
				<?php
				endif;
				wp_reset_query();

				if ($options['category_sidebar_position'] == 'right-sidebar') {
				?>
					<div class="{{TEXT_DOMAIN}}-blog-sidebar">
						<?php
						if (is_active_sidebar('blog-sidebar')):
							dynamic_sidebar('blog-sidebar');
						endif;
						?>
					</div>
				<?php
				}

				if ($options['category_sidebar_position'] == 'no-sidebar' && $class == 'list-view') {
				?>
					<div class="{{TEXT_DOMAIN}}-blog-sidebar"></div>
				<?php
				}
				?>
			</div>

		</div>
	</section>

</main>

<?php
get_footer();
