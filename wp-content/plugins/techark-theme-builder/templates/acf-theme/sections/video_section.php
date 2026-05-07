<?php

$section = $args['section'];

$heading = $section['heading'];
$video_list = $section['video_list'];

if (!empty($video_list) || !empty($heading)) {

    ?>
    <section class="py-75 {{THEME_PREFIX}}-videos">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <?php
            if (!empty($heading)) {
                ?>
                <h2 class="h2"><?php echo $heading ?></h2>
                <?php
            }
            ?>
            <div class="{{THEME_PREFIX}}-videos-row row" id="gallery-container">
                <?php
                $cnt = 0;
                foreach ($video_list as $video) {

                    $video_heading = $video['video_heading'];

                    $video_cover_image = "";

                    if (empty($video['video_cover_image'])) {
                        $video_cover_image = $section['default_placeholder_image'];
                    } else {
                        $video_cover_image = $video['video_cover_image'];
                    }

                    $video_id = 'video-' . $cnt;

                    switch ($video['video_type']) {

                        case 'youtube':
                            if (!empty($video['youtube_iframe_url'])) {
                                ?>
                                <div class="video-col" data-src="<?php echo $video['youtube_iframe_url']; ?>" data-poster="<?php echo $video_cover_image['url']; ?>" data-sub-html="<h4><?php echo $video_heading; ?></h4>">
                                    <div class="video-box">
                                        <?php
                                        echo getlazyload_img($video_cover_image, '100', '100');
                                        ?>
                                        <button data-lg-index="<?php echo esc_attr($cnt); ?>" data-video-trigger="<?php echo esc_attr($video_id); ?>" class="video-btn" title="Watch Now">
                                            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/sections-assets/images/play-button.svg'; ?>" alt="Watch Now-alt" title="Watch Now" height="100" width="100">
                                        </button>
                                    </div>
                                    <strong class="h5"><?php echo $video_heading; ?></strong>
                                </div>
                                <?php
                            }
                            break;
                        case 'vimeo':
                            if (!empty($video['vimeo_iframe_url'])) {
                                ?>
                                <div class="video-col" data-src="<?php echo $video['vimeo_iframe_url']; ?>" data-poster="<?php echo $video_cover_image['url']; ?>" data-sub-html="<h4><?php echo $video_heading; ?></h4>">
                                    <div class="video-box">
                                        <?php
                                        echo getlazyload_img($video_cover_image, '100', '100');
                                        ?>
                                        <button data-lg-index="<?php echo esc_attr($cnt); ?>" data-video-trigger="<?php echo esc_attr($video_id); ?>" class="video-btn" title="Watch Now">
                                            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/sections-assets/images/play-button.svg'; ?>" alt="Watch Now-alt" title="Watch Now" height="100" width="100">
                                        </button>
                                    </div>
                                    <strong class="h5"><?php echo $video_heading; ?></strong>
                                </div>
                                <?php
                            }
                            break;
                        case 'upload':
                            if (!empty($video['video_upload']['url'])) {
                                ?>
                                <div class="video-col" data-video='{"source": [{"src":"<?php echo $video['video_upload']['url']; ?>", "type":"<?php echo $video['video_upload']['mime_type']; ?>"}], "attributes": {"preload": false, "controls": true}}' data-poster="<?php echo $video_cover_image['url']; ?>" data-sub-html="<h4><?php echo $video_heading; ?></h4>">
                                    <div class="video-box">
                                        <?php
                                        echo getlazyload_img($video_cover_image, '100', '100');
                                        ?>
                                        <button data-lg-index="<?php echo esc_attr($cnt); ?>" data-video-trigger="<?php echo esc_attr($video_id); ?>" class="video-btn" title="Watch Now">
                                            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo get_stylesheet_directory_uri() . '/assets/sections-assets/images/play-button.svg'; ?>" alt="Watch Now-alt" title="Watch Now" height="100" width="100">
                                        </button>
                                    </div>
                                    <strong class="h5"><?php echo $video_heading; ?></strong>
                                </div>
                                <?php
                            }
                            break;
                    }
                    $cnt++;
                }
                ?>
            </div>
        </div>
    </section>
    <?php
}
