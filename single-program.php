<?php get_header() ?>

<?php get_template_part('template-parts/banner') ?>

<!-- All Queries -->
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
?>

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <a class="metabox__blog-home-link" href=<?php echo site_url('/programs') ?>>
                <i class="fa fa-home" aria-hidden="true"></i>
                All Programs
            </a>
            <span class="metabox__main"><?php the_title() ?></span>
        </p>

    </div>

    <div class="generic-content">
        <?php the_content() ?>
    </div>

	<!-- Professors lists that are related to this program -->
	<?php
		if($relatedProfessors->have_posts()){
			echo '<hr class="section-break">';
			echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';

			echo '<ul class="professor-cards">';
			while ($relatedProfessors->have_posts()) {
				$relatedProfessors->the_post();
			?>
				<li class="professor-card__list-item">
					<a class="professor-card" href="<?php the_permalink() ?>">
						<img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscaped') ?>" alt="">
						<span class="professor-card__name"><?php the_title() ?></span>
					</a>
				</li>
		<?php	}
			echo '</ul>';
		} wp_reset_postdata();
	?>

	<!-- Upcoming events lists that are related to this program -->
    <?php
        if ($relatedEvents->have_posts()){
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
        }

        while($relatedEvents->have_posts()){
            $relatedEvents->the_post();
            get_template_part('template-parts/content', 'event');
        }
        wp_reset_postdata();
    ?>

    <!-- Available campuses for this program -->

    <?php
        $relatedCampuses = get_field('related_campus');

        if ($relatedCampuses){
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' is available at these campuses.</h2>';
        }

        echo "<ul class='link-list min-list'>";
            foreach ($relatedCampuses as $campus) {
                ?>
                <li>
                    <a href="<?php echo get_the_permalink($campus) ?>">
                        <?php echo get_the_title($campus) ?>
                    </a>
                </li>
            <?php }
        echo "</ul>";
        wp_reset_postdata()
    ?>
</div>

<?php get_footer() ?>