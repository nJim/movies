<?php
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\field\MovieProfit
 */

namespace Drupal\movie_views\Plugin\views\field;
 
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
 
/**
 * Returns a movie's profit as its revenue minus expenses.
 * 
 * To calculate profit, this plugin joins the entity data table onto the tables
 * for the budget and revenue fields. Movies without a budget or revenue are 
 * excluded from the the calculation. Example views query below.
 * 
 * @code
 *   SELECT 
 *     revenue.field_revenue_value AS revenue_field_revenue_value, 
 *     budget.field_budget_value AS budget_field_budget_value, 
 *     (revenue.field_revenue_value - budget.field_budget_value) AS profit
 *   FROM
 *     {node_field_data} node_field_data
 *   LEFT JOIN 
 *     {node__field_revenue} revenue ON node_field_data.nid=revenue.entity_id
 *   LEFT JOIN 
 *     {node__field_budget} budget ON node_field_data.nid=budget.entity_id
 *   WHERE (
 *     (revenue.field_revenue_value != '0') 
 *     AND 
 *     (budget.field_budget_value != '0')
 *   )
 * @endcode
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("movie_profit")
 */
class MovieProfit extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    
    /** @var \Drupal\views\Plugin\views\query\Sql $query */
    $query = $this->query;
    
    // Joining on 'node_field_data', but it would work for other entities too.
    $base = $this->view->storage->get('base_table');

    // The views join manager allows us to instantiate our @ViewsJoin plugins.
    $joinManager = \Drupal::service('plugin.manager.views.join');

    // Join the base table onto the revenu field data table. 
    // LEFT JOIN node__field_budget ON node_field_data.nid=budget.entity_id
    $revenue_join = $joinManager->createInstance('movie_revenue_join');
    $revenue_alias = $query->addRelationship('revenue', $revenue_join, $base);

    // Join the base table onto the revenu field data table. 
    // LEFT JOIN node__field_revenue ON node_field_data.nid=revenue.entity_id
    $budget_join = $joinManager->createInstance('movie_budget_join');
    $budget_alias = $query->addRelationship('budget', $budget_join, $base);

    // Add the revenue and budget field values to the query.
    $query->addField($revenue_alias, 'field_revenue_value');
    $query->addField($budget_alias, 'field_budget_value');

    // Add where clause to remove movies without budget and revenue values.
    $query->addWhere(0, $revenue_alias.'.field_revenue_value', 0, '!=');
    $query->addWhere(0, $budget_alias.'.field_budget_value', 0, '!=');

    // Add the profit field to the view. This is calculated as revenue - budget.
    $formula = "({$revenue_alias}.field_revenue_value  - {$budget_alias}.field_budget_value)";
    $query->addField(NULL, $formula, 'profit');
  }
 
  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    // Return the custom field value.
    // Prefixing the dollar sign, but we could make this a plugin $option.
    return '$'. number_format($values->profit, 0, '.', ',');
  }

}
