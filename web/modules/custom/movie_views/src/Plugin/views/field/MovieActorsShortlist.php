<?php

/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\field\MovieActorsShortlist
 */

namespace Drupal\movie_views\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Returns a short list of actors in a given movie.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("movie_actors_shortlist_field")
 */
class MovieActorsShortlist extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    // The query method is required as plugins implement ViewsPluginInterface.
    // We are choosing to work in the render method, so leave this empty.

    // For this example, we could create a subquery that joins movies to cast to
    // actors and aggregates the results; but we would quickly find ourselves
    // in subquery hell. So let's keep the code easier on the eyes below.
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
    // The credits field relates a movie to credit nodes.
    $field = 'field_credit';

    // This view is built on the node base table, so we are given access to the
    // entire node object in the render method.
    $entity = $values->_entity;

    // The node must have field_credits for this views field plugin to work.
    // Exit early if this field is unavailable or does not have a value.
    if(!$entity->hasField($field) || $entity->get($field)->isEmpty()) {
      return NULL;
    }

    // Load the credit nodes related to this movie.
    $credits = $entity->get('field_credit')->referencedEntities();

    // The top three actors will be included in the shortlist by name.
    $names = array_map(function ($star) {
      $actors = $star->get('field_person')->referencedEntities();
      return $actors[0]->getTitle();
    }, array_slice($credits, 0, 3));

    // If the movie has more than three people, add a count after the stars.
    $others = count($credits) - 3;
    $suffix = $others > 0 ? " + {$others} more..." : '';

    // Example: Pierce Brosnan, Sean Bean, Izabella Scorupco + 19 more...
    return implode($names, ', ') . $suffix;
  }

}