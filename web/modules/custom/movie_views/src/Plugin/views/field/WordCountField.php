<?php

namespace Drupal\movie_views\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Display the number of words in the title field.
 *
 * This example has two solutions, with one of them commented out. This is to
 * demo how operations can take place in the query or render method. While this
 * example is trivial, the decision to use a query vs PHP can dramatically
 * impact the execution time and complexity of the code.
 *
 * @ViewsField("word_count_field")
 */
class WordCountField extends FieldPluginBase {

  /**
   * Option 1: Use a query and render the results.
   */
  public function query() {
    /** @var \Drupal\views\Plugin\views\query\Sql $query */
    $query = $this->query;

    // Field to compute.
    $field = "node_field_data.title";

    // Calculate the number of words in the field.
    $formula = "LENGTH({$field}) - LENGTH(REPLACE({$field}, ' ', '')) + 1";
    $query->addField(NULL, $formula, 'word_count');
  }

  public function render(ResultRow $values) {
    return $values->word_count;
  }

  /**
   * Option 2: Calculate the results from the available entity object.
   */
  // public function query() { }

  // public function render(ResultRow $values) {
  //   $title = $values->_entity->getTitle();
  //   return strlen($title) - strlen(str_replace(' ', '', $title)) + 1;
  // }

}
