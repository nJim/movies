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

  // Field for displaying the name of an actor in a given movie.
  $data['node']['movie_actors_name_field'] = [
    'title' => t('Actors in a Movie'),
    'field' => [
      'title' => t('Custom: Actors in a Movie'),
      'help' => t('Displays actors in a movie.'),
      'id' => 'movie_actors_name_field',
    ],
  ];

  // Field for displaying a teaser list of actors in a movie.
  // @todo: give this options.
  $data['node']['movie_actors_shortlist_field'] = [
    'title' => t('Short List of Actors'),
    'field' => [
      'title' => t('Custom: Short List of Actors'),
      'help' => t('Displays short list of actors in a movie.'),
      'id' => 'movie_actors_shortlist_field',
    ],
  ];

  // Field for comparing a movies budget and revenue.
  $data['node']['movie_profit'] = [
    'title' => t('Profit Calculation'),
    'field' => [
      'title' => t('Custom: Profit Calculation'),
      'help' => t('Calculates movie revenue minus budget.'),
      'id' => 'movie_profit',
    ],
  ];
}
