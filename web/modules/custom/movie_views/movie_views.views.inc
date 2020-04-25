<?php

/**
 * @file
 * Contains custom views support and definitions.
 */

 /**
 * Implements hook_views_data_alter().
 */
function movie_views_views_data_alter(array &$data) {
  $data['node']['movie_poster_rendered'] = [
    'title' => t('Movie Poster'),
    'field' => [
      'title' => t('Movie Poster'),
      'help' => t('Rendered movie poster.'),
      'id' => 'movie_poster_rendered',
    ],
  ];
}
