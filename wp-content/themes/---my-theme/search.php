<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package My_theme
 */

get_header();

$options = get_option('my_theme_options');

$layout = !empty($options['search_post_layout']) ? $options['search_post_layout'] : 'grid';

$class = ($layout === 'list') ? 'list-view' : '';

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

global $wp_query;

?>
<main id="main-content" class="site-main">
	<?php
	get_template_part('custom-templates/header-banner', null);

	?>
	<section class="my-theme-blog py-75">
		<div class="<?php echo esc_attr(my_theme_get_container_class()); ?>">
			<?php
			if ($options['enable_search_form'] &&  $options['search_sidebar_position'] == 'no-sidebar') {
			?>
				<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
					<label>
						<input type="search" class="search-field"
							placeholder="<?php echo esc_attr__('Search …', 'my-theme'); ?>"
							value="<?php echo get_search_query(); ?>" name="s" required />
					</label>
					<button type="submit" class="search-submit">
						<?php esc_html_e('Search', 'my-theme'); ?>
					</button>
				</form>
			<?php
			}
			?>
			<div class="my-theme-blog-row">
				<?php
				if ($options['search_sidebar_position'] == 'left-sidebar') {
				?>
					<div class="my-theme-blog-sidebar">
						<?php
						if (is_active_sidebar('blog-sidebar')):
							dynamic_sidebar('blog-sidebar');
						endif;
						?>
					</div>
				<?php
				}

				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'order' => 'DESC',
					'paged' => $paged,
					's' => get_search_query(),
				);

				$one = new WP_Query($args);

				if ($one->have_posts()) {
				?>
					<div class="my-theme-blog-card-wrapper">
						<div class="my-theme-blog-card-row <?php echo $class;  ?>">
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

								$content = esc_html(my_theme_get_excerpt_or_content(50));

							?>
								<div class="my-theme-blog-card">
									<a href="<?php echo get_permalink($post_id); ?>" class="img-block">
										<?php
										echo getlazyload_img($image_arr, '100', '100');
										if (! empty($options['search_page_metadata']) && in_array('date', $options['search_page_metadata'])) {
										?>
											<span class="post_date">
												<span><?php echo esc_html(get_the_date('d')); ?></span>
												<?php echo esc_html(get_the_date('M')); ?>
											</span>
										<?php
										}
										?>
									</a>
									<div class="content-block">
										<?php
										if (! empty($options['search_page_metadata']) && in_array('category', $options['search_page_metadata'])) {
											if ($categories) {
										?>
												<div class="categories">
													<?php
													$category_name = array();
													foreach ($categories as $category) {
														$category_name[] = '<a href="' . get_category_link($category->term_id) . '" >' . $category->name . '</a>';
													}
													echo join(", ", $category_name);
													?>
												</div>
										<?php
											}
										}

										?>
										<a href="<?php echo get_permalink($post_id); ?>" class="h3"><?php echo get_the_title($post_id); ?></a>
										<?php
										if ($content) {
										?>
											<p><?php echo $content; ?></p>
										<?php
										}
										?>
									</div>
								</div>
							<?php
							endwhile;
							?>
						</div>
						<nav aria-label="Page navigation">
							<?php
							$big = 999999999; // need an unlikely integer
							$total = $one->max_num_pages;

							if ($total > 1) {
								if (!$current_page = $paged)
									$current_page = 1;

								$pages = paginate_links(array(
									'base' => @add_query_arg('paged', '%#%'),
									'format' => '',
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
				} else {
				?>
					<div class="my-theme-blog-card-wrapper">
						<div class='text-center'>Sorry, but nothing matched your search terms.</div>
					</div>
				<?php
				}
				wp_reset_query();

				if ($options['search_sidebar_position'] == 'right-sidebar') {
				?>
					<div class="my-theme-blog-sidebar">
						<?php
						if (is_active_sidebar('blog-sidebar')):
							dynamic_sidebar('blog-sidebar');
						endif;
						?>
					</div>
				<?php
				}

				if ($options['search_sidebar_position'] == 'no-sidebar' && $class == 'list-view') {
				?>
					<div class="my-theme-blog-sidebar"></div>
				<?php
				}
				?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
