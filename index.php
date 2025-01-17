<?php get_header() ?>

<!-- BUG: Pulls out title and subtitle from first blog post -->
<?php get_template_part('template-parts/banner') ?> 

<div class="container container--narrow page-section">
    <!-- Posts -->
    <?php
        while(have_posts()){
            the_post(); 
    ?>
    <div class="post-item">
        <h2 class="headline headline--medium headline--post-title">
            <a href="<?php the_permalink() ?>">
                <?php the_title() ?>
            </a>
        </h2>
        <div class="metabox">
            <p>
                Posted by 
                <?php the_author_posts_link()?> 
                on 
                <?php the_modified_date()?> 
                at 
                <?php the_modified_date( 'g:i a' ) ?> 
                in
                <?php the_category(', ') ?>
            </p>
        </div>
        <div class="generic-content">
            <p><?php the_excerpt() ?></p>
            <p>
                <a class="btn btn--blue" href="<?php the_permalink() ?>">Continue Reading &raquo;</a>
            </p>
        </div>
    </div>
    <?php } ?>

    <!-- Pagination -->
     <!-- TODO: Change pagination query style /?page=1 not /page/1/  -->
    <?php echo paginate_links() ?>
</div>

<?php get_footer() ?>