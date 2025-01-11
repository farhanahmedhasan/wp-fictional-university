<?php
    /*
    Template Name: Event
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
    <!-- Event Posts -->
    <?php
        $events = new WP_Query([
            'post_type' => 'event',
            'posts_per_page' => 8,
            'meta_key' => 'event_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => [
              'key' => 'event_date',
              'compare' => '>=',
              'value' => Date('Y-m-d'),
            ]
        ]);

        while($events->have_posts()){
            $events->the_post(); 
            $event_date = new DateTime(get_field('event_date'));
    ?>
            <div class="event-summary">
                <a class="event-summary__date t-center" href="#">
                  <span class="event-summary__month"><?php echo $event_date->format('M') ?></span>
                  <span class="event-summary__day"><?php echo $event_date->format('j') ?></span>
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