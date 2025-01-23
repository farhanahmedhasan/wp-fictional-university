<?php get_header() ?>

<?php get_template_part('template-parts/banner') ?>

<?php
    $relatedPrograms = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'program',
        'meta_query' => [
            [
                'key' => 'related_campus',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
            ]
        ]
    ]);
?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <?php while(have_posts()){
                the_post();
                ?>
                <p>
                    <a class="metabox__blog-home-link" href=<?php echo site_url('/campuses') ?>>
                        <i class="fa fa-home" aria-hidden="true"></i>
                        All Campuses
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

        <div class="acf-map" id="acf-map">
            <?php
                $campusLocation = get_field('campus_location');
            ?>
            <div class="marker" data-lat="<?php echo $campusLocation['lat'] ?>" data-lng="<?php echo $campusLocation['lng'] ?>">
                <h3><?php the_title() ?></h3>
                <p style="margin-top: 8px"><?php echo $campusLocation['address'] ?></p>
            </div>
        </div>

        <!-- Related Programs -->
        <ul class="link-list min-list">
            <hr class="section-break">
            <h2 class="headline headline--medium">Program(s) available at this campus .</h2>

            <?php while($relatedPrograms->have_posts()){
                $relatedPrograms->the_post();
                ?>
                <li>
                    <a href="<?php the_permalink() ?>">
                        <?php the_title() ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>

<?php get_footer() ?>