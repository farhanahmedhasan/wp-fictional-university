<?php get_header(); 
    //if true (has parent) shows parent id else evaluate to 0
    $get_parent_page = wp_get_post_parent_id(get_the_ID());

    $get_parent_link = get_permalink($get_parent_page);
    $get_parent_title = get_the_title($get_parent_page);
?>

    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title() ?></h1>
        <div class="page-banner__intro">
          <p>Don't forget to replace me later</p>
        </div>
      </div>
    </div>

    
    <div class="container container--narrow page-section">
    <?php 
        if($get_parent_page){
    ?>

    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href=<?php echo $get_parent_link ?>>
            <i class="fa fa-home" aria-hidden="true"></i>
                Back to <?php echo $get_parent_title ?>
            </a> 
            <span class="metabox__main"><?php the_title() ?></span>
        </p>
    </div>

    <?php } ?>

    <?php 
        // gives the list of ids, if what page we are in has child pages
        // or gives 0 if current page we are in has no child
        $childIDs = get_pages([
            'child_of' => get_the_ID()
        ]);

        if($get_parent_page || $childIDs) { ?>
            <div class="page-links">
                <h2 class="page-links__title">
                    <a href=<?php echo $get_parent_link ?>>
                        <?php echo $get_parent_title ?>
                    </a>
                </h2>
                <ul class="min-list">
                    <?php 
                        $id = $get_parent_page ? $id = $get_parent_page : $id = get_the_ID();

                        wp_list_pages([
                            'title_li' => null,
                            'child_of' => $id,
                            'sort_column' => 'menu_order'
                        ]);
                    ?>
                </ul>
            </div>

    <?php } ?>

    <div class="generic-content">
        <?php the_content() ?>
    </div>
</div>
<?php get_footer(); ?>