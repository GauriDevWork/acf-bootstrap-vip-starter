<?php

$section = $args['section'];

$heading = $section['heading'];
$faq_list = $section['faq_list'];

$random_id = $args['id'];

if (!empty($heading) || !empty($faq_list)) {

    ?>
    <section class="{{THEME_PREFIX}}-accordion py-75">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?> accordion" id="{{THEME_PREFIX}}-accordion-<?php echo $random_id; ?>">
            <?php
            if (!empty($heading)) {
                ?>
                <h2 class="h2"><?php echo $heading ?></h2>
                <?php
            }

            if (!empty($faq_list)) {
                foreach ($faq_list as $index => $item) {

                    $question = !empty($item['question']) ? esc_html($item['question']) : '';
                    $answer = !empty($item['answer']) ? wp_kses_post($item['answer']) : '';

                    $is_first = ($index === 0);
                    $collapse_class = $is_first ? 'show' : '';
                    $button_class = $is_first ? '' : 'collapsed';
                    $aria_expanded = $is_first ? 'true' : 'false';
                    ?>
                    <div class="{{THEME_PREFIX}}-accordion-item">
                        <button tabindex="0" class="{{THEME_PREFIX}}-accordion-header <?php echo esc_attr($button_class); ?>" id="heading-<?php echo esc_attr($index);
                           echo $random_id; ?>" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo esc_attr($index);
                             echo $random_id; ?>" aria-expanded="<?php echo esc_attr($aria_expanded); ?>" aria-controls="collapse-<?php echo esc_attr($index);
                                  echo $random_id; ?>">
                            <span><?php echo $question; ?></span>
                            <span class="{{THEME_PREFIX}}-arrow"></span>
                        </button>

                        <div class="accordion-collapse collapse <?php echo esc_attr($collapse_class); ?>" id="collapse-<?php echo esc_attr($index);
                           echo $random_id; ?>" aria-labelledby="heading-<?php echo esc_attr($index);
                             echo $random_id; ?>" data-bs-parent="#{{THEME_PREFIX}}-accordion-<?php echo $random_id; ?>">
                            <div class="{{THEME_PREFIX}}-accordion-content">
                                <?php echo $answer; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }

            ?>
        </div>
    </section>
    <?php
}
?>