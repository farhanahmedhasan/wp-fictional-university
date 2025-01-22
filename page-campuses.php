<?php
    get_header();
    get_template_part('template-parts/banner');
?>

<div class="container container--narrow page-section">
    <!-- Campuses -->
    <div class="acf-map" id="acf-map">
        <?php
        $query = new WP_Query([
                'posts_per_page' => -1,
                'post_type' => 'campus',
                'order' => 'ASC'
        ]);

        while($query->have_posts()){
            $query->the_post();
            $campusLocation = get_field('campus_location');
            ?>
            <div class="marker" data-lat="<?php echo $campusLocation['lat'] ?>" data-lng="<?php echo $campusLocation['lng'] ?>"></div>
        <?php } ?>
    </div>


    <!-- Pagination -->
    <!-- TODO: Change pagination query style /?page=1 not /page/1/  -->
    <?php echo paginate_links() ?>
</div>

<?php get_footer() ?>
