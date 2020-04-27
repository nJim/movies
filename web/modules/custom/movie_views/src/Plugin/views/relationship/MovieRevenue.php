<?php

namespace Drupal\movie_views\Plugin\views\relationship;

use Drupal\views\ViewExecutable;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\relationship\RelationshipPluginBase;
use Drupal\views\Views;

/**
 * .
 *
 * @ingroup views_relationship_handlers
 *
 * @ViewsRelationship("movie_revenue_relationship")
 */

class MovieRevenue extends RelationshipPluginBase {

  public function query() {

    $baseTable = $this->view->storage->get('base_table'); //node_field_data
    
    $config = [
      'table' => 'node__field_revenue',
      'field' => 'entity_id',
      'left_table' => $baseTable,
      'left_field' => 'nid',
      'operator' => '=',
    ];

    $join = Views::pluginManager('join')->createInstance('standard', $config);
    $this->query->addRelationship('revenue', $join, $baseTable);
  }

}
