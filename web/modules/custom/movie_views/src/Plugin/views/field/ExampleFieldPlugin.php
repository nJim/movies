<?php
 
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\field\ExampleFieldPlugin
 */
 
namespace Drupal\movie_views\Plugin\views\field;
 
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\views\Views;
 
/**
 * Returns actors in a given movie.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("example_field_plugin")
 */
class ExampleFieldPlugin extends FieldPluginBase {
 
  public function query() {
    // The query method is required as plugins implement ViewsPluginInterface.
    // We are choosing to work in the render method, so leave this empty.
  }
 
  /**
   * Renders the field.
   *
   * @param \Drupal\views\ResultRow $values
   *   The values retrieved from a single row of a view's query result.
   *
   * @return string|\Drupal\Component\Render\MarkupInterface
   *   The rendered output. If the output is safe it will be wrapped in an
   *   object that implements MarkupInterface. If it is empty or unsafe it
   *   will be a string.
   */
  public function render(ResultRow $values) {
    return 'Example message';
  }

}