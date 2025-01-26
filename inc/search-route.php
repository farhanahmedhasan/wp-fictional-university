<?php

add_action('rest_api_init', 'registerSearch');

function registerSearch(): void {
    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_Server::READABLE, // This returns to 'GET' (benefits if any web host uses slightly different value)
        'callback' => 'getSearchResults'
    ]);
}

function getSearchResults(WP_REST_Request $request): array {
    return [
        'cat' => 'meow',
        'professors' => getProfessors($request),
    ];
}

function getProfessors ($request): array {
    $searchKeyword = $request->get_param('keyword');

    $professorQuery = new WP_Query([
        'post_type' => 'professor',
        's' => _sanitize_text_fields($searchKeyword),
        'posts_per_page' => -1
    ]);

    return array_map(function($post) {
        return [
            'title' => get_the_title($post->ID),
            'link' => get_the_permalink($post->ID)
        ];
    }, $professorQuery->posts);
}