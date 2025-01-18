<?php get_header() ?>

<?php get_template_part('template-parts/banner') ?> 

<div class="container container--narrow page-section">
    <!-- Event Posts -->
    <?php
        $query = getEventQuery(['query_operator' => '<=']);

        while($query->have_posts()){
            $query->the_post(); 
			get_template_part('template-parts/content', 'event');
 		} 
    ?>

    <!-- Pagination -->
    <!-- TODO: Change pagination query style /?page=1 not /page/1/  -->
    <?php 
        echo paginate_links([
            'total' => $query->max_num_pages,
        ]);
    ?>
</div>

<?php get_footer() ?>