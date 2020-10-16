<?php
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\sort\WordCountSort
 */

namespace Drupal\movie_views\Plugin\views\sort;

use Drupal\views\Plugin\views\sort\SortPluginBase;

/**
 * Example plugin for sorting by a word count query.
 *
 * @ViewsSort("word_count_sort")
 */
class WordCountSort extends SortPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Ensure the main table for this handler is in the query.
    $this->ensureMyTable();

    /** @var \Drupal\views\Plugin\views\query\Sql $query */
    $query = $this->query;

    // Field to compute.
    $field = "node_field_data.title";

    // Calculate the number of words in the field and sort by this value.
    $formula = "LENGTH({$field}) - LENGTH(REPLACE({$field}, ' ', '')) + 1";
    $query->addOrderBy(NULL, $formula, $this->options['order'], 'word_count');
  }

}
