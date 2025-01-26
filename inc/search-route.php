<?php

add_action('rest_api_init', 'registerSearch');

function registerSearch(): void {
    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_Server::READABLE, // This returns to 'GET' (benefits if any web host uses slightly different value)
        'callback' => 'getSearchResults'
    ]);
}

function getSearchResults(WP_REST_Request $request): array {
    return getMultiplePostsByType($request);
}

function getMultiplePostsByType ($request): array {
    $searchKeyword = $request->get_param('keyword');

    $postTypes = ['post', 'page', 'professor', 'program', 'campus', 'event'];
    $results = [];

    foreach ($postTypes as $postType){
        $query = new WP_Query([
            'post_type' => $postType,
            's' => _sanitize_text_fields($searchKeyword),
            'posts_per_page' => -1
        ]);

        if ($postType === "post" || $postType === "page") {
            $posts = array_map(function($post) {
                return [
                    'author_name'=> get_the_author_meta('display_name', $post->post_author),
                    'title' => get_the_title($post->ID),
                    'link' => get_the_permalink($post->ID),
                    'post_type' => get_post_type($post->ID),
                ];
            }, $query->posts);

            $results['generalInfo'] = array_merge($results['generalInfo'] ?? [], $posts);
            continue;
        }

        $results[$postType] = array_map(function($post) {
            return [
                'author_name'=> get_the_author_meta('display_name', $post->post_author),
                'title' => get_the_title($post->ID),
                'link' => get_the_permalink($post->ID),
                'post_type' => get_post_type($post->ID),
            ];
        }, $query->posts);
    }

    return $results;
}