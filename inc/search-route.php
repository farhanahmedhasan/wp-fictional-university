<?php

add_action('rest_api_init', 'registerSearch');

function registerSearch(): void {
    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_Server::READABLE, // This returns to 'GET' (benefits if any web host uses slightly different value)
        'callback' => 'getSearchResults'
    ]);
}

function getSearchResults(): array {
    return [
        'cat' => 'meow',
        'professors' => getProfessors()
    ];
}

function getProfessors (): array {
    $professorQuery = new WP_Query([
        'post_type' => 'professor',
        'posts_per_page' => -1
    ]);

    $professors = [];

    while ($professorQuery->have_posts()){
        $professorQuery->the_post();

        $professors[] = [
            'title' => get_the_title(),
            'link' => get_the_permalink()
        ];
    }

    return $professors;
}