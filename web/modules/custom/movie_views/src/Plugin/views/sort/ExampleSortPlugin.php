<?php
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\sort\ExampleSortPlugin
 */

namespace Drupal\movie_views\Plugin\views\sort;

use Drupal\views\Plugin\views\sort\SortPluginBase;

/**
 * Example plugin boillerplate for creating a custom sort.
 *
 * @ViewsSort("example_sort_plugin")
 */
class ExampleSortPlugin extends SortPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Ensure the main table for this handler is in the query.
    $this->ensureMyTable();

    /** @var \Drupal\views\Plugin\views\query\Sql $query */
    $query = $this->query;

    // Sort using the methods in Drupals APIs.
    // $this->query->addOrderBy($field, $value, $condition);
  }

}
