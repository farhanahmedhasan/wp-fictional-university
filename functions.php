<?php

add_action('wp_enqueue_scripts', 'loadUniversityResources');

function loadUniversityResources(){
    wp_enqueue_style('university_main_css', get_stylesheet_uri());
}