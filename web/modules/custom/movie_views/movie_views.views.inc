<?php

/**
 * @file
 * Contains custom views support and definitions.
 */

 /**
 * Implements hook_views_data_alter().
 */
function movie_views_views_data_alter(array &$data) {
  // Field for rendering a movie poster as an image.
  $data['node']['movie_poster_rendered_field'] = [
    'title' => t('Movie Poster'),
    'field' => [
      'title' => t('Custom: Movie Poster'),
      'help' => t('Rendered movie poster.'),
      'id' => 'movie_poster_rendered_field',
    ],
  ];
}
