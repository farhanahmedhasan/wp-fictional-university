<?php

require get_theme_file_path('/inc/search-route.php');

add_action('wp_enqueue_scripts', 'loadUniversityResources');
add_action('after_setup_theme', 'loadUniversityFeatures');
add_action('pre_get_posts', 'adjustQueries');
add_action('rest_api_init', 'universityCustomRest');
add_action('admin_init', 'redirectSubsOnLogin');
add_action('wp_loaded', 'removeAdminBarForSubs');

add_filter('body_class', 'addCustomPostTypeBodyClass');

add_action('login_enqueue_scripts', 'loginCss');
add_filter('login_headerurl', 'changeHeaderUrl');
add_filter('login_headertext', 'loginTitle');
add_filter('wp_nav_menu_items', 'filterNavMenu', 10, 2);

function filterNavMenu($items, $args) {
  if ($args->theme_location === 'header_menu' && !is_user_logged_in()){
    $items = preg_replace('/<li[^>]*>.*?My Notes.*?<\/li>/', '', $items);
  }
  return $items;
}

function loginTitle(): ?string {
  return get_bloginfo('name');
}

function loginCss(): void {
  wp_enqueue_style('university_normalized_css', get_theme_file_uri( '/build/index.css' ));
  wp_enqueue_style('university_main_css', get_theme_file_uri( '/build/style-index.css' ));
  wp_enqueue_style('google_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
}

function changeHeaderUrl(): string {
  return esc_url(site_url('/'));
}

function removeAdminBarForSubs(): void {
  $user = wp_get_current_user();
  if (count($user->roles) === 1 && $user->roles[0] === 'subscriber'){
    show_admin_bar(false);
  }
}

function redirectSubsOnLogin(): void {
  $user = wp_get_current_user();
  if (count($user->roles) === 1 && $user->roles[0] === 'subscriber'){
    wp_redirect(site_url('/'));
    exit;
  }
}

function universityCustomRest(): void {
  register_rest_field('post', 'authorName', [
    'get_callback' => function() {
    return get_the_author();
  }
  ]);
}

function addCustomPostTypeBodyClass($classes){
    if (is_page('campuses')) {
        $classes[] = 'page-campuses';
    }

    if (is_singular('campus')){
        $classes[] = 'single-campus';
    }

    return $classes;
}

function loadUniversityResources(){
    wp_enqueue_style('university_normalized_css', get_theme_file_uri( '/build/index.css' ));
    wp_enqueue_style('university_main_css', get_theme_file_uri( '/build/style-index.css' ));
    wp_enqueue_style('google_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');

    wp_enqueue_script( 'main_js', get_theme_file_uri('/build/index.js'), ['jquery'], 1.0, true);
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], null, true);
}

function loadUniversityFeatures(){
    register_nav_menu('header_menu', 'Header Menu Location');
    register_nav_menu('footer_menu_one', 'Footer Menu One Location');
    register_nav_menu('footer_menu_two', 'Footer Menu Two Location');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('pageBanner', 1500, 460, true);
    add_image_size('professorLandscaped', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
}

function adjustQueries($query){
    if(!is_admin() && $query->is_main_query()){
        $query->set('posts_per_page', 4);
    }
}

function getEventQuery($args = []){
    $defaults = [
        'posts_per_page' => 4,
        'key' => 'event_date',
        'query_operator' => '>=',
        'show_all' => false
    ];

    $args = wp_parse_args( $args, $defaults );

    $meta_query = [
        'key' => $args['key'],
        'compare' => $args['query_operator'],
        'value' => Date('Y-m-d'),
    ];

    if($args['show_all']){
        $meta_query = [];
    }

    return new WP_Query([
        'post_type' => 'event',
        'posts_per_page' => $args['posts_per_page'],
        'meta_key' => $args['key'],
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => $meta_query,
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1
    ]);
}

function getProgramQuery(){
    return new WP_Query([
        'post_type' => 'program',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ]);
}