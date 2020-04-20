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

    $movies = \Drupal::service('tmdb.list');
    $movies->getListById();
    var_dump(get_class_methods($movies->getMovies()));


    return [
      '#type' => 'markup',
      '#markup' => $this->t('Lil help?')
    ];
  }

}
