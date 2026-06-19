<?php
$layout = get_field( 'footer_layout', 'option' ) ?: 'layout1';
?>

<footer class="site-footer">
    <?php get_template_part( 'template-parts/footer/footer', $layout ); ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>