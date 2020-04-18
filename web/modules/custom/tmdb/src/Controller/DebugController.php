<?php

namespace Drupal\tmdb\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DebugController.
 */
class DebugController extends ControllerBase {

  /**
   * Debugger page contents.
   *
   * @return string
   *   Return the debug page contents.
   */
  public function contents() {

    $movie = \Drupal::service('tmdb.movie');
    $movie->setMovieId();
    var_dump($movie->getImdbId());


    return [
      '#type' => 'markup',
      '#markup' => $this->t('Lil help?')
    ];
  }

}