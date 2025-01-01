<?php 
    get_header();
    while (have_posts()) {
        the_post(); ?>
        <div>
            <h2>
                <a href="<?php the_permalink()?>">
                    <?php the_title()?>
                </a>
            </h2>
            <p><?php the_content()?></p>
            <hr/>
        </div>
    <?php }

    get_footer();
?>