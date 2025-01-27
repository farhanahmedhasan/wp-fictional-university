<?php

add_action('rest_api_init', 'registerSearch');

function registerSearch(): void {
    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_Server::READABLE, // This returns to 'GET' (benefits if any web host uses slightly different value)
        'callback' => 'getSearchResults'
    ]);
}

function getSearchResults(WP_REST_Request $request): array {
    $postTypes = ['post', 'page', 'program', 'professor', 'campus', 'event'];

    return [
        'results' => getMultiplePostsByType($request, $postTypes),
        'view_all_post_type_links' => getAllPostTypeLinks()
    ];
}

function getMultiplePostsByType ($request, $postTypes): array {
    $searchKeyword = $request->get_param('keyword');
    $results = [];

    foreach ($postTypes as $postType){
        $query = new WP_Query([
            'post_type' => $postType,
            's' => _sanitize_text_fields($searchKeyword),
            'posts_per_page' => -1
        ]);

        if ($postType === "post" || $postType === "page") {
            $posts = array_map(fn($post)=> getFields($post, $postType), $query->posts);
            $results['generalInfo'] = array_merge($results['generalInfo'] ?? [], $posts);
            continue;
        }

        $results[$postType] = array_map(fn($post)=> getFields($post, $postType), $query->posts);

        if($postType === 'professor' && !empty($results['program'])){
            $programMetaQuery = [
                'relation' => 'OR'
            ];

            foreach ($results['program'] as $post){
                $programMetaQuery[] = [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . $post['id'] . '"'
                ];
            }

            $programRelationQuery = new WP_Query([
                'post_type' => 'professor',
                'posts_per_page' => -1,
                'meta_query' => $programMetaQuery
            ]);

            $relatedProf = array_map(fn($post)=> getFields($post, $postType), $programRelationQuery->posts);
            $results['professor'] = array_merge($results['professor'] ?? [], $relatedProf);

            $results['professor'] = array_unique($results['professor'], SORT_REGULAR);
        }
    }

    return $results;
}

function getAllPostTypeLinks(): array {
    return [
        'post' => home_url('/blog/'),
        'program' => home_url('/programs/'),
        'campus' => home_url('/campuses/'),
        'event' => home_url('/events/'),
    ];
}

function getFields($post, $postType): array {
    $fields = [
        'id' => $post->ID,
        'author_name'=> get_the_author_meta('display_name', $post->post_author),
        'title' => get_the_title($post->ID),
        'link' => get_the_permalink($post->ID),
        'post_type' => get_post_type($post->ID),
    ];

    if($postType === 'professor'){
        $fields['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'professorLandscaped');
    }

    if($postType === 'event'){
        $event_date = new DateTime(get_field('event_date', $post->ID));

        $fields['excerpt'] = has_excerpt($post->ID) ? get_the_excerpt($post->ID) : wp_trim_words(get_post_field('post_content',$post->ID), 18);
        $fields['upcoming_event_time'] = [
            'event_full_time' => get_field('event_date', $post->ID),
            'event_month' => $event_date->format('M'),
            'event_day' => $event_date->format('j')
        ];

    }

    return $fields;
}