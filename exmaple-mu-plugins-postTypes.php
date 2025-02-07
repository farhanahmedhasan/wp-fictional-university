<?php
  add_action('init', 'loadUniversityPostTypes');

  function loadUniversityPostTypes(){
    // Event Post Type
    register_post_type('event', [
      'capability_type' => 'event',
      'map_meta_cap' => true,
      'show_in_rest' => true,
      'supports' => ['title', 'editor', 'excerpt'],
      'public' => true,
      'has_archive' => true,
      'labels' => getLabels('Events'),
      'menu_icon' => 'dashicons-calendar',
      'rewrite' => ['with_front' => false],
    ]);

    // Program Post Type
    register_post_type('program', [
      'show_in_rest' => true,
      'supports' => ['title', 'editor'],
      'public' => true,
      'has_archive' => true,
      'labels' => getLabels('Programs'),
      'menu_icon' => 'dashicons-awards',
      'rewrite' => ['with_front' => false],
    ]);

    // Professor Post Type
    register_post_type('professor', [
      'show_in_rest' => true,
      'supports' => ['title', 'editor', 'thumbnail'],
      'labels' => getLabels('Professors'),
      'public' => true,
      'menu_icon' => 'dashicons-welcome-learn-more',
      'rewrite' => ['with_front' => false],
    ]);

    // Campus post type
    register_post_type('campus', [
      'capability_type' => 'campus',
      'map_meta_cap' => true,
      'show_in_rest' => true,
      'supports' => ['title', 'editor'],
      'public' => true,
      'labels'=> getLabels('Campuses'),
      'menu_icon' => 'dashicons-location-alt',
      'rewrite' => ['with_front' => false],
    ]);

    // Note Post Type
    register_post_type('notebook', [
      'show_in_rest' => true,
      'supports' => ['title', 'editor'],
      'labels' => getLabels('Notebooks'),
      'public' => false,
      'show_ui' => true,
      'menu_icon' => 'dashicons-welcome-write-blog',
    ]);
  }

  function getLabels($pluralName){
    $singularName = substr($pluralName, -2) === 'es' ? substr($pluralName, 0, -2) : substr($pluralName, 0, -1);
    return [
      'name' => $pluralName,
      'singular_name' => $singularName,
      'all_items' => "All $pluralName",
      'add_new_item' => "Add New $singularName",
      'edit_item' => "Edit $singularName",
    ];
  }