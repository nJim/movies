<?php
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\join\MovieRevenueJoin
 */

namespace Drupal\movie_views\Plugin\views\join;

use Drupal\views\Plugin\views\join\JoinPluginBase;
use Drupal\views\Plugin\views\join\JoinPluginInterface;

/**
 * Views plugin for joining the revenue field data table to the node base table.
 *
 * Note: This code is unnecessary as the views module creates relationships for
 * each field created with the Field API. This is here as an example of a join
 * handler. This pattern is more useful for joining to custom entities.
 *
 * @ingroup views_join_handlers
 *
 * @ViewsJoin("movie_revenue_join")
 */
class MovieRevenueJoin extends JoinPluginBase implements JoinPluginInterface {

  /**
   * Create static instance of this class.
   */
  public static function create(array $configuration, $plugin_id, $plugin_definition) {
    // Set default configuration.
    $configuration = array_merge([
      'type' => 'LEFT',
      'table' => 'node__field_revenue',
      'field' => 'entity_id',
      'left_table' => 'node_field_data',
      'left_field' => 'nid',
      'operator' => '=',
    ], $configuration);

    $plugin_id = empty($plugin_id) ? 'movie_revenue_join' : $plugin_id;

    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

  /**
   * Builds the SQL for the join this object represents.
   *
   * When possible, try to use table alias instead of table names.
   *
   * @param $select_query
   *   An select query object.
   * @param $table
   *   The base table to join.
   * @param \Drupal\views\Plugin\views\query\QueryPluginBase $view_query
   *   The source views query.
   */
  public function buildJoin($select_query, $table, $view_query) {
    $select_query->addJoin(
      'LEFT',
      'node__field_revenue',
      'revenue',
      'node_field_data.nid=revenue.entity_id'
    );
  }

}
