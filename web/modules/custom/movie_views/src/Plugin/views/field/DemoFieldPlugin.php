<?php

namespace Drupal\movie_views\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * A blank plugin used as a starting place for a live demo.
 *
 * @ViewsField("demo_field_plugin")
 */
class DemoFieldPlugin extends FieldPluginBase {

  public function query() { }

  public function render(ResultRow $values) {
    return 'Example plugin';
  }

}
