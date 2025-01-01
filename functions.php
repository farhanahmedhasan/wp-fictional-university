<?php

add_action('wp_enqueue_scripts', 'loadUniversityResources');

function loadUniversityResources(){
    wp_enqueue_style('university_main_css', get_theme_file_uri( '/build/style-index.css' ));
    wp_enqueue_style('university_normalized_css', get_theme_file_uri( '/build/index.css' ));
}