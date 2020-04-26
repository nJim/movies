<?php

namespace Drupal\tmdb\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Fetches movie details from TMDB for any movie with a TMDB ID.
 *
 * @Action(
 *   id = "update_movie_action",
 *   label = @Translation("Update Movie Details"),
 *   type = "node",
 *   requirements = {
 *     "_permission" = "edit any movie content",
 *   },
 * )
 */
class UpdateMovieAction extends ActionBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    $tmdbId = $entity->get('field_tmdb_id')->getString();
    $movie = \Drupal::service('tmdb.client')->fetchMovie($tmdbId);

    if ($movie['id']) {
      $entity->set('title',              $movie['title']);
      $entity->set('field_imdb_id',      $movie['id']);
      $entity->set('field_banner_path',  $movie['backdrop_path']);
      $entity->set('field_poster_path',  $movie['poster_path']);
      $entity->set('field_release_date', $movie['release_date']);
      $entity->set('field_imdb_id',      $movie['imdb_id']);
      $entity->set('field_popularity',   $movie['popularity']);
      $entity->set('field_revenue',      $movie['revenue']);
      $entity->set('field_tagline',      $movie['tagline']);
      $entity->set('field_vote_average', $movie['vote_average']);
      $entity->set('field_vote_count',   $movie['vote_count']);
      $entity->set('field_budget',       $movie['budget']);
      $entity->set('field_synopsis', [
        'value' => $movie['overview'],
        'format' => 'basic_html',
      ]);
      $entity->save();
    }

    return $this->t('Nailed it!');
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    /** @var \Drupal\Core\Entity\EntityInterface $object */
    return $object->access('update', $account, $return_as_object);
  }

}
