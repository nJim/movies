<?php

namespace Drupal\tmdb\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Update a person node with TMDB data.
 *
 * @Action(
 *   id = "update_person_action",
 *   label = @Translation("Update Person Details"),
 *   type = "node",
 *   requirements = {
 *     "_permission" = "edit any movie content",
 *   },
 * )
 */
class UpdatePersonAction extends ActionBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    $tmdbId = $entity->get('field_tmdb_id')->getString();
    $data = \Drupal::service('tmdb.client')->fetchPerson($tmdbId);

    if ($data['id']) {
      $entity->set('title',              $data['name']);
      $entity->set('field_birthday',     $data['birthday']);
      $entity->set('field_imdb_id',      $data['imdb_id']);
      $entity->set('field_popularity',   $data['popularity']);
      $entity->set('field_profile_path', $data['profile_path']);
      $entity->set('field_tmdb_id',      $data['id']);
      $entity->set('field_biography', [
        'value' => $data['biography'],
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
