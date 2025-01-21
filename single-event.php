<?php get_header() ?>

<?php get_template_part('template-parts/banner') ?> 

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <?php while(have_posts()){
             the_post(); 
        ?>
        <p>
          <a class="metabox__blog-home-link" href=<?php echo site_url('/events') ?>>
            <i class="fa fa-home" aria-hidden="true"></i>
                Events Home
            </a> 
            <span class="metabox__main">
                Posted by 
                <?php echo the_author_posts_link()?> 
                on 
                <?php the_modified_date()?> 
                at 
                <?php the_modified_date( 'g:i a' ) ?> 
            </span>
        </p>
        <?php } ?>
    </div>

    <div class="generic-content">
        <?php the_content() ?>
    </div>

    <!-- Related Programs -->
    <?php 
        $relatedPrograms = get_field('related_programs');
        
        if($relatedPrograms){ ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Related Program(s)</h2>
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