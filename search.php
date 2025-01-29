<?php get_header() ?>

<?php
    get_template_part('template-parts/banner', null, [
        'title' => 'Search Results',
        'subtitle' => "You searched for &ldquo;" . get_search_query() . "&rdquo;"
    ])
?>

    <div class="container container--narrow page-section">
        <?php
            if(!have_posts()){
                echo "<h2 class='headline headline--small-plus'>No results matched that search.</h2>";
            }

            while(have_posts()){
                the_post();
                get_template_part('template-parts/content', get_post_type());
            }
        ?>

        <div>
            <p style="margin: 20px 0">
                <!-- TODO: Change pagination query style /?page=1 not /page/1/  -->
                <?php echo paginate_links(); ?>
            </p>
            <?php get_search_form(); ?>
        </div>

    </div>

<?php get_footer() ?>