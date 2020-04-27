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

  // Creates a relationship between the base table and the revenue field values.
  // This example uses a vustom views plug to create the relationship.
  // This is just an example, as views automatically creates relationships for
  // each field created with the Field API.
  $data['node']['movie_revenue'] = [
    'title' => t('Custom: Revenue Relationship'),
    'help' => t('Find revenue values related to an entity.'),
    'relationship' => [
      'id' => 'movie_revenue_relationship',
    ],  
  ];

  // Creates a relationship between the base table and the budget field values.
  // This example simply passes values to the 'standard' views plugin.
  // This is just an example, as views automatically creates relationships for
  // each field created with the Field API.
  $data['node']['movie_budget'] = [
    'title' => t('Custom: Budget Relationship'),
    'help' => t('Find revenue values related to an entity.'),
    'relationship' => [
      'title' => t('Custom: Budget Relationship'),
      'label' => t('Custom: Budget Relationship'),
      'base' => 'node__field_budget',
      'base field' => 'entity_id',
      'relationship field' => 'nid',
      'id' => 'standard',      
    ],  
  ];

}
