<?php

add_action('rest_api_init', 'registerSearch');

function registerSearch(): void
{
    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_Server::READABLE, // This returns to 'GET' (benefits if any web host uses slightly different value)
        'callback' => 'getSearchResults'
    ]);
}

function getSearchResults()
{
    return 'Congratulation You Created a ROUTE';
}