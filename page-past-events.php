<?php get_header() ?>

<?php get_template_part('template-parts/banner') ?> 

<div class="container container--narrow page-section">
    <!-- Event Posts -->
    <?php
        $query = getEventQuery(['query_operator' => '<=']);

        while($query->have_posts()){
            $query->the_post(); 
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
    <?php 
        echo paginate_links([
            'total' => $query->max_num_pages,
        ]);
    ?>
</div>

<?php get_footer() ?>