<?php
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\sort\MovieProfitSort
 */

namespace Drupal\movie_views\Plugin\views\sort;

use Drupal\views\Plugin\views\sort\SortPluginBase;

/**
 * Sorts movies by profits.
 *
 * @ViewsSort("movie_profit")
 */
class MovieProfitSort extends SortPluginBase {

  /**
   * Provide a list of options for the default sort form.
   */
  protected function sortOptions() {
    return [
      'ASC' => $this->t('Hemeraged the most money first'),
      'DESC' => $this->t('The least bad first'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Ensure the main table for this handler is in the query.
    $this->ensureMyTable();

    /** @var \Drupal\views\Plugin\views\query\Sql $query */
    $query = $this->query;

    // Joining on 'node_field_data', but it would work for other entities too.
    $base = $this->view->storage->get('base_table');

    // The views join manager allows us to instantiate our @ViewsJoin plugins.
    $joinManager = \Drupal::service('plugin.manager.views.join');

    // Join the base table onto the revenu field data table.
    // LEFT JOIN node__field_budget ON node_field_data.nid=budget.entity_id
    $revenue_config = [
      'type' => 'INNER',
      'table' => 'node__field_revenue',
      'field' => 'entity_id',
      'left_table' => $base,
      'left_field' => 'nid',
      'operator' => '=',
    ];
    $revenue_join = $joinManager->createInstance('standard', $revenue_config);
    $revenue_alias = $query->addRelationship('revenue_join', $revenue_join, $base);

    // Join the base table onto the revenu field data table.
    // LEFT JOIN node__field_revenue ON node_field_data.nid=revenue.entity_id
    $budget_config = [
      'type' => 'INNER',
      'table' => 'node__field_budget',
      'field' => 'entity_id',
      'left_table' => 'node_field_data',
      'left_field' => 'nid',
      'operator' => '=',
    ];
    $budget_join = $joinManager->createInstance('standard', $budget_config);
    $budget_alias = $query->addRelationship('budget_join', $budget_join, $base);

    // Add the revenue and budget field values to the query.
    $query->addField($revenue_alias, 'field_revenue_value');
    $query->addField($budget_alias, 'field_budget_value');

    // Add where clause to remove movies without budget and revenue values.
    // @todo: Remove movies where revenue was greater than budget.
    $query->addWhere(0, $revenue_alias.'.field_revenue_value', 0, '!=');
    $query->addWhere(0, $budget_alias.'.field_budget_value', 0, '!=');

    // Add the profit field to the view. This is calculated as revenue - budget.
    $formula = "({$revenue_alias}.field_revenue_value  - {$budget_alias}.field_budget_value)";
    $this->query->addOrderBy(NULL, $formula, $this->options['order'], 'profit_sort');
  }

}
