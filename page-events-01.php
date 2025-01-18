<?php
    /*
    Template Name: Events Style 01
    */
    get_header(); 
?>

<?php get_template_part("template-parts/banner"); ?>

<div class="container container--narrow page-section">
    <!-- Event Posts -->
    <?php
        $query = getEventQuery();

        while($query->have_posts()){
            $query->the_post(); 
            get_template_part('template-parts/content', 'event');
        } 
    ?>

    <!-- Pagination -->
    <!-- TODO: Change pagination query style /?page=1 not /page/1/  -->
    <?php 
        echo paginate_links([
            'current' => max(1, get_query_var('paged')),
            'total' => $query->max_num_pages,
        ]);
    ?>

    <hr class="section-break">

    <p>Looking for a recap of past events? 
        <a href="<?php echo site_url('/past-events') ?>">
            Check out our past events.
        </a>
    </p>
</div>

<?php get_footer() ?>