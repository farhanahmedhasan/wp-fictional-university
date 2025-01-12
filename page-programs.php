<?php get_header() ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Welcome to our Programs</h1>
        <div class="page-banner__intro">
            <p>All the programs we offer</p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <!-- Posts -->
    <ul class="link-list min-list">
        <?php
            $query = new WP_Query([
                'post_type' => 'program',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
            ]);

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