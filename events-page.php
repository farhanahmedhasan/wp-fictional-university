<?php
    /*
    Template Name: Events
    */
    get_header(); 
?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title() ?></h1>
        <div class="page-banner__intro">
            <p><?php the_content() ?></p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <!-- Posts -->
    <?php
        $events = new WP_Query([
            'post_type' => 'event',
            'posts_per_page' => 8,
        ]);

        while($events->have_posts()){
            $events->the_post(); 
    ?>
            <div class="event-summary">
                <a class="event-summary__date t-center" href="#">
                  <span class="event-summary__month"><?php the_time('M') ?></span>
                  <span class="event-summary__day"><?php the_time('j') ?></span>
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny">
                    <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                  </h5>
                  <p>
                    <?php the_excerpt() ?>
                    <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a>
                  </p>
                </div>
            </div>
    <?php } ?>

    <!-- Pagination -->
     <!-- TODO: Change pagination query style /?page=1 not /page/1/  -->
    <?php echo paginate_links() ?>
</div>

<?php get_footer() ?>