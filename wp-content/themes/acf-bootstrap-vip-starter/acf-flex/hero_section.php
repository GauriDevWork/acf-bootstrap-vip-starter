<?php
$heading = get_sub_field('heading');
$content = get_sub_field('content');
$button  = get_sub_field('button');
?>

<section class="section-hero py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">

                <?php if ($heading): ?>
                    <h1><?php echo esc_html($heading); ?></h1>
                <?php endif; ?>

                <?php if ($content): ?>
                    <p><?php echo esc_html($content); ?></p>
                <?php endif; ?>

                <?php if ($button): ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="btn btn-primary">
                        <?php echo esc_html($button['title']); ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>