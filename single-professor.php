<?php get_header() ?>

<?php get_template_part('template-parts/banner') ?>

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