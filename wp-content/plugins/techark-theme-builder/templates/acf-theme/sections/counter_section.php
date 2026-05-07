<?php

$section = $args['section'];

$counter_list = $section['counter_list'];

if (!empty($counter_list)) {

?>
    <section class="{{THEME_PREFIX}}-counter-sec py-75">
        <div class="<?php echo esc_attr({{THEME_PREFIX}}get_container_class()); ?>">
            <div class="content-row">
                <?php
                foreach ($counter_list as $counter) {

                ?>
                    <div class="content-block">
                        <?php
                        if (!empty($counter['number_count'])) {
                        ?>
                            <span class="count-block">
                                <span class="count" data-count="<?php echo round($counter['number_count']); ?>">0</span>
                                <?php
                                if (!empty($counter['sign'])) {
                                    echo $counter['sign'];
                                }
                                ?>
                            </span>
                        <?php
                        }
                        if (!empty($counter['content'])) {
                        ?>
                            <p><?php echo $counter['content']; ?></p>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
}

?>