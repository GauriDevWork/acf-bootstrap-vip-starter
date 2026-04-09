<?php
/**
 * FAQ Section
 */
$heading = get_sub_field('heading');
$settings = acf_vip_section_settings();
?>

<section <?php echo $settings['id']; ?> class="section-faq <?php echo $settings['spacing']; ?> <?php echo $settings['class']; ?>">

    <div class="<?php echo $settings['container']; ?>">

        <?php if ($heading): ?>
            <h2 class="text-center mb-5">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if (have_rows('faqs')): ?>
            
            <div class="faq-wrapper">

                <?php $i = 0; while (have_rows('faqs')): the_row(); 
                    $question = get_sub_field('question');
                    $answer   = get_sub_field('answer');
                    $faq_id   = 'faq-' . $i;
                ?>

                    <div class="faq-item">

                        <button 
                            class="faq-question"
                            aria-expanded="false"
                            aria-controls="<?php echo esc_attr($faq_id); ?>"
                        >
                            <?php echo esc_html($question); ?>
                        </button>

                        <div 
                            id="<?php echo esc_attr($faq_id); ?>"
                            class="faq-answer"
                            hidden
                        >
                            <?php echo wp_kses_post($answer); ?>
                        </div>

                    </div>

                <?php $i++; endwhile; ?>

            </div>

        <?php endif; ?>

    </div>

</section>