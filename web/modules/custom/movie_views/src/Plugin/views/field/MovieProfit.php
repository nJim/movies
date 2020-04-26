<?php
 
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\field\MovieProfit
 */
 
namespace Drupal\movie_views\Plugin\views\field;
 
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

use Drupal\views\Views;
 
/**
 * Returns a movie's profit as its revenue minus expenses.
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
    // $query = $this->query;
    
    $baseTable = $this->view->storage->get('base_table'); //node_field_data
    
    $configuration = [
      'table' => 'node__field_revenue',
      'field' => 'entity_id',
      'left_table' => $baseTable,
      'left_field' => 'nid',
      'operator' => '=',
    ];

    $join = Views::pluginManager('join')->createInstance('standard', $configuration);
    $join_revenue_table_alias = $this->query->addRelationship('revenue', $join, $baseTable);



    $configuration = [
      'table' => 'node__field_budget',
      'field' => 'entity_id',
      'left_table' => $baseTable,
      'left_field' => 'nid',
      'operator' => '=',
    ];

    $join = Views::pluginManager('join')->createInstance('standard', $configuration);
    $join_budget_table_alias = $this->query->addRelationship('budget', $join, $baseTable);

    $this->query->addField($join_revenue_table_alias, 'field_revenue_value', 'r');
    $this->query->addField($join_budget_table_alias, 'field_budget_value', 'b');

    $this->query->addWhere($this->options['group'], 'revenue.field_revenue_value', 0, '!=');
    $this->query->addWhere($this->options['group'], 'budget.field_budget_value', 0, '!=');

    // can't use alaises in views addField or expressions at all.
    $this->query->addField(NULL, '(revenue.field_revenue_value - budget.field_budget_value)', 'profit');
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
    return $values->profit;
  }

}