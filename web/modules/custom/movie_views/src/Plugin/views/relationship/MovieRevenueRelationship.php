<?php
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\relationship\MovieRevenueRelationship
 */

namespace Drupal\movie_views\Plugin\views\relationship;

use Drupal\views\Plugin\views\relationship\RelationshipPluginBase;
use Drupal\views\Views;

/**
 * Custom views plugin for relating revenue field data to an entity.
 *
 * Note: This example is unnecessary as the views module automatically creates
 * relationships for fields created with the Field API. This code is here to
 * show how a join plugin may be used to define a relationship.
 *
 * @ingroup views_relationship_handlers
 *
 * @ViewsRelationship("movie_revenue_relationship")
 */
class MovieRevenueRelationship extends RelationshipPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    $config = [
      'table' => 'node__field_revenue',
      'field' => 'entity_id',
      'left_table' => 'node_field_data',
      'left_field' => 'nid',
      'operator' => '=',
    ];
    $join = Views::pluginManager('join')->createInstance('standard', $config);
    $this->query->addRelationship('revenue', $join, 'node_field_data');
  }

}
