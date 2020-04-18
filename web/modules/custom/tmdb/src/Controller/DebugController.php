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

    $client = \Drupal::service('tmdb.api');
    $things = $client->getMovie();
    var_dump($things);


    return [
      '#type' => 'markup',
      '#markup' => $this->t('Lil help?')
    ];
  }

}
