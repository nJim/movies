<?php

/**
 * @file
 * Contains custom views support and definitions.
 */

/**
 * Implements hook_views_data_alter().
 */
function movie_views_views_data_alter(array &$data) {

  // Field Plugin for Demo
  $data['node_field_data']['demo_field_plugin'] = [
    'title' => t('Demo Field Plugin'),
    'field' => [
      'help' => t('A field plugin for live demo.'),
      'id' => 'demo_field_plugin',
    ],
  ];

  // Example Field Plugin
  $data['node_field_data']['example_field_plugin'] = [
    'title' => t('Example Field Plugin'),
    'field' => [
      'help' => t('This is the help text.'),
      'id' => 'example_field_plugin',
    ],
  ];

  // Field for rendering a movie poster as an image.
  $data['node_field_data']['movie_poster_rendered_field'] = [
    'title' => t('Movie Poster'),
    'field' => [
      'help' => t('Rendered movie poster.'),
      'id' => 'movie_poster_rendered_field',
    ],
  ];

  // Field for rendering a movie poster as an image.
  $data['node_field_data']['movie_mylist'] = [
    'title' => t('My List'),
    'field' => [
      'help' => t('Add or remove from my list.'),
      'id' => 'movie_my_list_field',
    ],
  ];

  // Field for displaying a teaser list of actors in a movie.
  $data['node_field_data']['movie_actors_shortlist_field'] = [
    'title' => t('Short List of Actors'),
    'field' => [
      'help' => t('Displays short list of actors in a movie.'),
      'id' => 'movie_actors_shortlist_field',
    ],
  ];

  // Example Sort Plugin for Demo.
  $data['node_field_data']['example_sort_plugin'] = [
    'title' => t('Example Sort Plugin'),
    'sort' => [
      'help' => t('Lets make a sort.'),
      'id' => 'example_sort_plugin',
    ],
  ];

  // Sort by word count in title field.
  $data['node_field_data']['word_count_sort'] = [
    'title' => t('Word Count'),
    'sort' => [
      'help' => t('Sort by word count of title.'),
      'id' => 'word_count_sort',
    ],
  ];

  // Sort on word count.


  // Field for comparing a movies budget and revenue.
  $data['node_field_data']['movie_profit'] = [
    'title' => t('Custom: Profit Calculation'),
    'field' => [
      'help' => t('Calculates movie revenue minus budget.'),
      'id' => 'movie_profit',
    ],
    'sort' => [
      'help' => t('Sort by movie profits.'),
      'id' => 'movie_profit',
    ],
  ];

  // Example Filter Plugin for Demo
  $data['node_field_data']['example_filter_plugin'] = [
    'title' => t('Example Filter Plugin'),
    'filter' => [
      'help' => t('Lets make a filter.'),
      'id' => 'example_filter_plugin',
    ],
  ];

  // Filter for movies with excited titles
  $data['node_field_data']['movie_excited_filter'] = [
    'title' => t('Excited Title'),
    'filter' => [
      'help' => t('Movies with an exclamation mark in title.'),
      'id' => 'movie_excited_filter',
    ],
  ];

  // Creates a relationship between the base table and the revenue field values.
  // This example uses a custom views plug to create the relationship.
  // This is just an example, as views automatically creates relationships for
  // each field created with the Field API.
  $data['node_field_data']['movie_revenue'] = [
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
  $data['node_field_data']['movie_budget'] = [
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
