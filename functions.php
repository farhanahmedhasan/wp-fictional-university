<?php

add_action('wp_enqueue_scripts', 'loadUniversityResources');
add_action( 'after_setup_theme', 'loadUniversityFeatures' );

function loadUniversityResources(){
    wp_enqueue_style('university_normalized_css', get_theme_file_uri( '/build/index.css' ));
    wp_enqueue_style('university_main_css', get_theme_file_uri( '/build/style-index.css' ));
    wp_enqueue_style('google_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    wp_enqueue_script( 'main_js', get_theme_file_uri('/build/index.js'), ['jquery'], 1.0, true);
}

function loadUniversityFeatures(){
    add_theme_support('title-tag');
}