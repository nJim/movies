<?php
 
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\field\MoviePosterRendered
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
 * @ViewsField("movie_actors_name_field")
 */
class MovieActorsName extends FieldPluginBase {
 
  /**
   * @{inheritdoc}
   */
  public function query() {
    /** @var \Drupal\views\Plugin\views\query\Sql $query */
    // $query = $this->query;
    
    $baseTable = $this->view->storage->get('base_table'); //node_field_data
    
    $configuration = [
      'table' => 'node__field_credit',
      'field' => 'entity_id',
      'left_table' => $baseTable,
      'left_field' => 'nid',
      'operator' => '=',
    ];

    $join = Views::pluginManager('join')->createInstance('standard', $configuration);
    $join_table_alias = $this->query->addRelationship('credit', $join, $baseTable);

    $this->query->addField($join_table_alias, 'field_credit_target_id', 'whatever');
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
    dpm(get_object_vars($values));
    return 'yolo';
  }

}