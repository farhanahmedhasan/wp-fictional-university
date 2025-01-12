<?php
add_action('init', 'loadUniversityPostTypes');

function loadUniversityPostTypes(){
    // Event Post Type
    $eventLabels = [
        'name'=> 'Events',
        'singular_name' => 'Event',
        'all_items' => 'All Events',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
    ];

    register_post_type('event', [
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'excerpt'],
        'public' => true,
        'has_archive' => true,
        'labels' => $eventLabels,
        'menu_icon' => 'dashicons-calendar',
        'rewrite' => ['with_front' => false],
    ]);

    // Program Post Type
    $programLabels = [
        'name' => 'Programs',
        'singular_name' => 'Program',
        'all_items' => 'All Programs',
        'add_new_item' => 'Add New Program',
        'edit_item' => 'Edit Program',
    ];

    register_post_type('program', [
        'show_in_rest' => true,
        'supports' => ['title', 'editor'],
        'public' => true,
        'has_archive' => true,
        'labels' => $programLabels,
        'menu_icon' => 'dashicons-awards',
        'rewrite' => ['with_front' => false],
    ]);
}