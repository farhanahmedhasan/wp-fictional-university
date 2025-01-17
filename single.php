<?php get_header() ?>

<?php get_template_part('template-parts/banner') ?> 

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <?php while(have_posts()){
             the_post(); 
        ?>
        <p>
          <a class="metabox__blog-home-link" href=<?php echo site_url('/blog') ?>>
            <i class="fa fa-home" aria-hidden="true"></i>
                Blog Home
            </a> 
            <span class="metabox__main">
                Posted by 
                <?php echo the_author_posts_link()?> 
                on 
                <?php the_modified_date()?> 
                at 
                <?php the_modified_date( 'g:i a' ) ?> 
                in
                <?php the_category(', ') ?>
            </span>
        </p>
        <?php } ?>
    </div>

    <div class="generic-content">
        <?php the_content() ?>
    </div>
</div>

<?php get_footer() ?>