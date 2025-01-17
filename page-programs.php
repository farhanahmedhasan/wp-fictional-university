<?php get_header() ?>

<?php get_template_part("template-parts/banner", null, [
        'title'=> 'Welcome to our Programs'
    ]); 
?>

<div class="container container--narrow page-section">
    <!-- Posts -->
    <ul class="link-list min-list">
        <?php
            $query = getProgramQuery();

            while($query->have_posts()){
                $query->the_post(); 
        ?>
            <li>
                <a href="<?php the_permalink() ?>">
                    <?php the_title() ?>
                </a>
            </li>
        <?php } ?>
    </ul>
    

    <!-- Pagination -->
     <!-- TODO: Change pagination query style /?page=1 not /page/1/  -->
    <?php echo paginate_links() ?>
</div>

<?php get_footer() ?>