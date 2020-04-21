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
    $tmdbId = $entity->get('field_tmdb_id')->getString();
    $data = \Drupal::service('tmdb.client')->fetchMovie($tmdbId);

    if ($data['id'] && $data['genres']) {
      $terms_to_add = [];
      // A movie may belong to one or more genres.
      foreach ($data["genres"] as $genre) {
        // Check if a taxonomy term already exists for this genre.
        $terms = \Drupal::entityTypeManager()
          ->getStorage('taxonomy_term')
          ->loadByProperties(['field_tmdb_id' => $genre['id']]);
        // Create a taxonomy term if one does not exist in drupal.
        if (!count($terms)) {
          $term = \Drupal\taxonomy\Entity\Term::create([
            'name' => $genre['name'], 
            'vid' => 'genre',
          ]);
          $term->set('field_tmdb_id',   $genre['id']);
          $term->save();
          // Save the new term id to add to the movie node.
          $terms_to_add[] = $term->id();
        }
        else {
          // The term alrady exists; save the term id to add to the movie node.
          $first = reset($terms);
          $terms_to_add[] = $first->id();
        }
      }

      // Set each of the genre terms on the movie's entity reference field.
      foreach($terms_to_add as $index => $id) {
        if($index == 0) {
          $entity->set('field_genre', $id);
        } else {
          $entity->get('field_genre')->appendItem([
            'target_id' => $id,
          ]);
        }
      }
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
