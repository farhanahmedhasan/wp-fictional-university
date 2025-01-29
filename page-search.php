<?php
    get_header();
    get_template_part('template-parts/banner');
?>

<div class="container container--narrow page-section">
    <div class="generic-content">
        <?php get_search_form() ?>
    </div>
</div>

<?php get_footer(); ?>