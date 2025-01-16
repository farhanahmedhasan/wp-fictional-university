<?php get_header() ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title() ?></h1>
        <div class="page-banner__intro">
          <p>Master in Biology</p>
        </div>
    </div>
</div>
<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <?php while(have_posts()){
             the_post(); 
        ?>
        <p>
          <a class="metabox__blog-home-link" href=<?php echo site_url('/programs') ?>>
            <i class="fa fa-home" aria-hidden="true"></i>
                All Programs
            </a> 
            <span class="metabox__main">
                <?php the_title() ?>
            </span>
        </p>
        <?php } ?>
    </div>

    <div class="generic-content">
        <?php the_content() ?>
    </div>

	<!-- Professors lists that are related to this program -->
	<?php 
		$relatedProfessors = new WP_Query([
			'posts_per_page' => -1,
			'post_type' => 'professor',
			'orderBy' => 'title',
			'order' => 'ASC',
			'meta_query' => [
				[
					'key' => 'related_programs',
					'compare' => 'LIKE',
					'value' => '"' . get_the_ID() . '"'
				]
			]
		]);

		if($relatedProfessors->have_posts()){
			echo '<hr class="section-break">';
			echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';

			while ($relatedProfessors->have_posts()) {
				$relatedProfessors->the_post();
			?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
				
		<?php	}
		} wp_reset_postdata();
	?>


	<!-- Up coming events lists that are related to this program -->
    <?php 
        $relatedEvents = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'event',
			'orderBy' => 'meta_value',
			'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => date('Y-m-d'),
                ],
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                ]
            ]
        ]);    

        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

        while($relatedEvents->have_posts()){
            $relatedEvents->the_post();
            $event_date = new DateTime(get_field('event_date'));
    ?>
            <div class="event-summary">
            <a class="event-summary__date event-summary__date--beige t-center" href="">
              <span class="event-summary__month"><?php echo $event_date->format('M'); ?></span>
              <span class="event-summary__day"><?php echo $event_date->format('j'); ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny">
                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
              </h5>
              <p> 
                <?php 
                  $excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 18);
                  echo $excerpt;
                ?> 
                <a href="<?php the_permalink() ?>" class="nu gray">Read more</a>
              </p>
            </div>
            </div>

    <?php } ?>
</div>

<?php get_footer() ?>