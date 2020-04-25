<?php

namespace Drupal\tmdb\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

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

    $multiplier = 10;
    $nids = \Drupal::entityQuery('node')->condition('type','movie')->execute();

    foreach ($nids as $nid) { 
      if (($nid >= $multiplier*50 + 0) && ($nid < $multiplier*50 + 50)) {
        $credits_to_add = [];
        $movie = Node::load($nid);
        $tmdbId = $movie->get('field_tmdb_id')->getString();
        $cast = \Drupal::service('tmdb.client')->fetchMovieCastCredits($tmdbId);
        foreach ($cast as $member) {

          $checkIfPerson = \Drupal::entityTypeManager()
            ->getStorage('node')
            ->loadByProperties(['field_tmdb_id' => $member['id']]);
          if(!count($checkIfPerson)) {
            $person = Node::create([
              'type'        => 'person',
              'title'       => !empty($member['name']) ? $member['name'] : 'Unlisted',
            ]);
            $person->set('field_tmdb_id', $member['id']);
            $person->save();
          }
          else {
            $person = reset($checkIfPerson);
          }


          $checkIfCredit = \Drupal::entityTypeManager()
            ->getStorage('node')
            ->loadByProperties(['field_tmdb_credit_id' => $member['credit_id']]);
          if(!count($checkIfCredit)) {
            if(strlen($member['character']) >= 255) {
              $character = substr($member['character'],0,254);
            }
            elseif(empty($member['character'])) {
              $character = 'Unlisted';
            }
            else {
              $character = $member['character'];
            }
            $credit = Node::create([
              'type'        => 'credit',
              'title'       => $character,
            ]);
            $credit->set('field_tmdb_credit_id', $member['credit_id']);
            $credit->set('field_order', $member['order']);
            $credit->set('field_person', $person->id());
            $credit->save();
          }
          else {
            $credit = reset($checkIfCredit);
          }
          $credits_to_add[] = $credit->id();
        }
        $movie->set('field_credit', $credits_to_add);
        $movie->save();
      }
    }








    // $movies = \Drupal::service('tmdb.client')->getMoviesFromList();
    // $data = \Drupal::service('tmdb.client')->fetchMovie($movie['id']);


    // $movies = \Drupal::service('tmdb.client')->getMoviesFromList();
    // foreach ($movies as $movie) {
      // $nodes = \Drupal::entityTypeManager()
      //   ->getStorage('node')
      //   ->loadByProperties(['field_tmdb_id' => $movie['id']]);
      // $node = reset($nodes);
      // if ($node->id()) {
        // $node->set('field_banner_path', $movie['backdrop_path']);
        // $node->set('field_poster_path', $movie['poster_path']);
        // $node->set('field_release_date', $movie['release_date']);
        // $node->set('field_synopsis', array(
        //   'value' => $movie['overview'],
        //   'format' => 'basic_html',
        //   ));
        // $node->save();
    //   }
    // }

    return [
      '#type' => 'markup',
      '#markup' => $this->t('Lil help?'),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
