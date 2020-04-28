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
   *
   * Should be overridden by classes that don't override sort_form.
   */
  protected function sortOptions() {
    return [
      'ASC' => $this->t('Unflagged first'),
      'DESC' => $this->t('Flagged first'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function query() {

    $this->ensureMyTable();
    $query = $this->query;

    // Joining on 'node_field_data', but it would work for other entities too.
    $base = $this->view->storage->get('base_table');

    // The views join manager allows us to instantiate our @ViewsJoin plugins.
    $joinManager = \Drupal::service('plugin.manager.views.join');
    $revenue_join = $joinManager->createInstance('movie_revenue_join');
    $revenue_alias = $query->addRelationship('revenue', $revenue_join, $base);
    $budget_join = $joinManager->createInstance('movie_budget_join');
    $budget_alias = $query->addRelationship('budget', $budget_join, $base);
    $query->addField($revenue_alias, 'field_revenue_value');
    $query->addField($budget_alias, 'field_budget_value');
    $query->addWhere(0, $revenue_alias.'.field_revenue_value', 0, '!=');
    $query->addWhere(0, $budget_alias.'.field_budget_value', 0, '!=');

    $formula = "({$revenue_alias}.field_revenue_value  - {$budget_alias}.field_budget_value)";
    
    // @see: \Drupal\views\Plugin\views\query\Sql
    $this->query->addOrderBy(NULL, $formula, 'DESC', 'profit_sort');
  }

}
