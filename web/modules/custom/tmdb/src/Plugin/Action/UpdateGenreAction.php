<?php

namespace Drupal\tmdb\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Fetches genres for a movie and creates/add taxonomy terms.
 *
 * @Action(
 *   id = "update_genre_action",
 *   label = @Translation("Update Movie Genre"),
 *   type = "node",
 *   requirements = {
 *     "_permission" = "edit any movie content",
 *   },
 * )
 */
class UpdateGenreAction extends ActionBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    // Fetch the movie details from TMDB API.
    $data = $this->getMovieDetails($entity->get('field_tmdb_id')->getString());
    
    if ($data['id'] && $data['genres']) {
      $terms_to_add = [];
      // A movie may belong to one or more genres.
      foreach ($data["genres"] as $genre) {
        // Check if the genre is already associated with a term in drupal.
        // Add the drupal taxonomy term to the array of terms for this movie.
        $terms_to_add[] = $this->getGenreDrupalIdFromTmdbID($genre['id']);
      }
      // Set each of the genre terms on the movie's entity reference field.
      $entity->set('field_genre', $terms_to_add);
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

  public function getMovieDetails($tmdbId) {
    return \Drupal::service('tmdb.client')->fetchMovie($tmdbId);
  }

  public function getGenreDrupalIdFromTmdbID($tmdbId) {
    // Check if a taxonomy term already exists with this genres TMDB ID.
    $terms = $this->getTermsByTmdbId($tmdbId);
    // Return the matching term so that it can be added to the movie node.
    // Create a taxonomy term if one does not exist in drupal.
    $term = count($terms)
      ? reset($terms)
      : $this->createGenre($genre['name'], $genre['id']);
    return $term->id();
  }

  public function getTermsByTmdbId($tmdbId) {
    return \Drupal::entityTypeManager()
    ->getStorage('taxonomy_term')
    ->loadByProperties(['field_tmdb_id' => $tmdbId]);
  }

  public function createGenre($name, $tmdbId) {
    $term = \Drupal\taxonomy\Entity\Term::create([
      'name' => $name, 
      'vid' => 'genre',
    ]);
    $term->set('field_tmdb_id',   $tmdbId);
    return $term->save();
  }

}
