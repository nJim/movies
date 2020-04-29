<?php

namespace Drupal\tmdb\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Fetches keywords for a movie and creates/add taxonomy terms.
 *
 * @Action(
 *   id = "update_keywords_action",
 *   label = @Translation("Update Movie Keywords"),
 *   type = "node",
 *   requirements = {
 *     "_permission" = "edit any movie content",
 *   },
 * )
 */
class UpdateKeywordsAction extends ActionBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    
    // Fetch the movie details from TMDB API.
    $data = $this->getMovieKeywords($entity->get('field_tmdb_id')->getString());

    if ($data['id'] && $data['keywords']) {
      $terms_to_add = [];
      // A movie may belong to one or more keyword.
      foreach ($data["keywords"] as $keyword) {
        // Check if the keyword is already associated with a term in drupal.
        // Add the drupal taxonomy term to the array of terms for this movie.
        $terms_to_add[] = $this->getKeywordDrupalIdFromTmdbID($keyword['id'], $keyword);
      }
      // Set each of the keyword terms on the movie's entity reference field.
      $entity->set('field_keywords', $terms_to_add);
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

  public function getMovieKeywords($tmdbId) {
    return \Drupal::service('tmdb.client')->fetchMovieKeywords($tmdbId);
  }

  public function getKeywordDrupalIdFromTmdbID($tmdbId, $keyword) {
    // Check if a taxonomy term already exists with this keywords TMDB ID.
    $terms = $this->getTermsByTmdbId($tmdbId);
    // Return the matching term so that it can be added to the movie node.
    // Create a taxonomy term if one does not exist in drupal.
    $term = count($terms)
      ? reset($terms)
      : $this->createTerm($keyword['name'], $keyword['id']);
    return $term->id();
  }

  public function getTermsByTmdbId($tmdbId) {
    return \Drupal::entityTypeManager()
    ->getStorage('taxonomy_term')
    ->loadByProperties(['field_tmdb_id' => $tmdbId]);
  }

  public function createTerm($name, $tmdbId) {
    $term = \Drupal\taxonomy\Entity\Term::create([
      'name' => $name, 
      'vid' => 'keywords',
    ]);
    $term->set('field_tmdb_id',   $tmdbId);
    $term->save();
    return $term;
  }

}
