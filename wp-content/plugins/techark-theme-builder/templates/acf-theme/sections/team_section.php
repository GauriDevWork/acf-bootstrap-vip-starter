<?php

$section = $args['section'];

$teams = $section['teams'];

if (!empty($teams)) {

    ?>
    <section class="py-75 {{THEME_PREFIX}}-teams">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <?php

            foreach ($teams as $team_group) {

                $heading = $team_group['heading'];
                $content = $team_group['content'];

                if (!empty($heading) || !empty($content)) {
                    ?>
                    <div class="main-title-center">
                        <?php
                        if (!empty($heading)) {
                            ?>
                            <h2 class="h2"><?php echo $heading; ?></h2>
                            <?php
                        }
                        if (!empty($content)) {
                            echo $content;
                        }
                        ?>
                    </div>
                    <?php
                }

                if (!empty($team_group['member_list'])) {

                    ?>
                    <div class="row">
                        <?php
                        foreach ($team_group['member_list'] as $member) {

                            $member_id = $member->ID;

                            $url = !empty(get_the_post_thumbnail_url($member_id, 'full')) ? get_the_post_thumbnail_url($member_id, 'full') : $section['default_placeholder_image']['url'];
                            $image_arr = array(
                                'url' => $url,
                                'alt' => get_the_title($member_id),
                                'title' => get_the_title($member_id)
                            );

                            $member_name = get_the_title($member_id);

                            $position = get_field('position', $member_id);
                            $linkedin_url = get_field('linkedin_url', $member_id);

                            $content = $member->post_content;

                            ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="leadership-box wow fadeInUp">
                                    <?php
                                    echo getlazyload_img($image_arr);

                                    if (!empty($member_name)) {
                                        ?>
                                        <h3 class="h5">
                                            <?php
                                            echo esc_html($member_name);

                                            ?>
                                        </h3>
                                        <?php
                                    }
                                    if (!empty($position)) {
                                        ?>
                                        <h4 class="h6">
                                            <?php
                                            echo esc_html($position);
                                            ?>
                                        </h4>
                                        <?php
                                    }

                                    if (!empty(trim($content))) {

                                        $trimmed = wp_strip_all_tags($content);

                                        echo '<p>' . $trimmed . '</p>';

                                    }

                                    if (!empty($linkedin_url)) {
                                        ?>
                                        <div class="social-profile">
                                            <a target="_blank" href="<?php echo $linkedin_url; ?>" class="linkedin-icon">
                                                <b class="d-none">LinkedIn</b>
                                            </a>
                                        </div>
                                        <?php
                                    }

                                    if (!empty(trim($content))) {
                                        ?>
                                        <button type="button" class="{{THEME_PREFIX}}-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop-<?php echo $member_id; ?>" aria-controls="staticBackdrop-<?php echo $member_id; ?>" aria-haspopup="dialog" aria-expanded="false">Read More</button>
                                        <?php
                                    }

                                    ?>
                                    <div class="modal fade" id="staticBackdrop-<?php echo $member_id; ?>" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" role="dialog" aria-modal="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="h3"><?php echo $member_name; ?></h2>
                                                    <h3 class="h6"><?php echo $position; ?></h3>
                                                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    $member_post = get_post($member_id);
                                                    echo wpautop($member_post->post_content);
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <?php
}
