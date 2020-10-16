<?php

/**
* @file
* Definition of Drupal\movie_views\Plugin\views\filter\ExcitedTitleFilter.
*/

namespace Drupal\movie_views\Plugin\views\filter;

use Drupal\views\Plugin\views\filter\FilterPluginBase;

/**
* Filters a list of node titles that include an exclamation mark.
*
* @ingroup views_filter_handlers
*
* @ViewsFilter("movie_excited_filter")
*/
class ExcitedTitleFilter extends FilterPluginBase {

/**
   * Add this filter to the query.
   */
  public function query() {
    // Ensure the main table for this handler is in the query.
    $this->ensureMyTable();

    // Add a condition where the title contains the exclamation mark.
    $this->query->addWhere($this->options['group'], 'title', '!', 'REGEXP');
  }

 }
