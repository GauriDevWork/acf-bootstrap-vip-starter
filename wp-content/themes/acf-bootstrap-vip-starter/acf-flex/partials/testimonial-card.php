<?php
$content = get_sub_field('content');
$name = get_sub_field('name');
$designation = get_sub_field('designation');
$image = get_sub_field('image');
?>

<div class="testimonial-card text-center h-100">

    <?php if ($image): ?>
        <div class="testimonial-img mb-3">
            <?php acf_vip_image($image, 'rounded-circle'); ?>
        </div>
    <?php endif; ?>

    <?php if ($content): ?>
        <blockquote class="testimonial-text">
            "<?php echo $content; ?>"
        </blockquote>
    <?php endif; ?>

    <?php if ($name): ?>
        <h5><?php echo esc_html($name); ?></h5>
    <?php endif; ?>

    <?php if ($designation): ?>
        <span class="testimonial-role">
            <?php echo esc_html($designation); ?>
        </span>
    <?php endif; ?>

</div>