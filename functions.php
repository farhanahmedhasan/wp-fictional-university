<?php

add_action('wp_enqueue_scripts', 'loadUniversityResources');
add_action('after_setup_theme', 'loadUniversityFeatures');
add_action('pre_get_posts', 'adjustQueries');

function loadUniversityResources(){
    wp_enqueue_style('university_normalized_css', get_theme_file_uri( '/build/index.css' ));
    wp_enqueue_style('university_main_css', get_theme_file_uri( '/build/style-index.css' ));
    wp_enqueue_style('google_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    wp_enqueue_script( 'main_js', get_theme_file_uri('/build/index.js'), ['jquery'], 1.0, true);
}

function loadUniversityFeatures(){
    register_nav_menu('header_menu', 'Header Menu Location');
    register_nav_menu('footer_menu_one', 'Footer Menu One Location');
    register_nav_menu('footer_menu_two', 'Footer Menu Two Location');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
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