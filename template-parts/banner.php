<?php 
    $title = $args['title'] ?? get_the_title();
    $subtitle = $args['subtitle'] ?? get_field('page_banner_subtitle');

    $custom_page_banner = get_field('page_banner_bg_image');
    $default_banner = get_theme_file_uri('/images/ocean.jpg');
    $bg_image = $args['bg_image'] ?? $custom_page_banner ? $custom_page_banner['sizes']['pageBanner'] : $default_banner;

    if(!$subtitle){
        $subtitle = "";
    }

?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $bg_image ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $title ?></h1>
        <div class="page-banner__intro">
            <p>
                <?php echo $subtitle ?>
            </p>
        </div>
    </div>
</div>
