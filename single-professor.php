<?php get_header() ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_field('page_banner_bg_image')['sizes']['PageBanner'] ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title() ?></h1>
        <div class="page-banner__intro">
            <p>
                <?php the_field('page_banner_subtitle') ?>
            </p>
        </div>
    </div>
</div>
<div class="container container--narrow page-section">
    <div class="generic-content">
        <div class="row group">
            <div class="one-third">
                <?php the_post_thumbnail('professorPortrait') ?>
            </div>

            <div class="two-third">
                <?php the_content() ?>
            </div>
        </div>
    </div>

    <!-- Related Programs -->
    <?php 
        $relatedPrograms = get_field('related_programs');
        
        if($relatedPrograms){ ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Subject(s) Taught</h2>
            <ul class="link-list min-list">
                <?php
                    foreach ($relatedPrograms as $program) {
                ?>
                        <li>
                            <a href="<?php the_permalink($program) ?>">
                                <?php echo $program->post_title ?>
                            </a>
                        </li>
                        
                <?php } ?>
            </ul>
    <?php } ?>
</div>

<?php get_footer() ?>