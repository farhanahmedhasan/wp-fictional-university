<?php get_header() ?>

<?php get_template_part('template-parts/banner') ?>

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

    </div>

<?php get_footer() ?>