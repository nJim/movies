<?php
 
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\filter\ExampleFilterPlugin.
 */

namespace Drupal\movie_views\Plugin\views\filter;

use Drupal\views\Plugin\views\filter\FilterPluginBase;

/**
* Filters a list of node titles that include an exclamation mark.
*
* @ingroup views_filter_handlers
*
* @ViewsFilter("example_filter_plugin")
*/
class ExampleFilterPlugin extends FilterPluginBase {

  /**
   * Add this filter to the query.
   */
  public function query() {
    // Ensure the main table for this handler is in the query.
    $this->ensureMyTable();
  }

}
