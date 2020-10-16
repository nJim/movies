<?php

/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\field\MoviePosterRendered
 */

namespace Drupal\movie_views\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Renders a movie poster as a views field.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("movie_poster_rendered_field")
 */
class MoviePosterRendered extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['image_size'] = ['default' => 'w92'];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['image_size'] = [
      '#title' => $this->t('Image Size'),
      '#description' => $this->t("Specify the image size from TMDB."),
      '#type' => 'select',
      '#default_value' => $this->options['image_size'],
      '#options' => [
        'w92' => 'Thumbnail',
        'w500' => 'Box'
      ]
    ];
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * @{inheritdoc}
   */
  public function query() {
    // The query method is required as plugins implement ViewsPluginInterface.
    // We don't need to alter the query, so leave an empty method.
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
    // This views plugin uses the poster path to create a rendered image.
    $field = 'field_poster_path';

    // This view is built on the node base table, so we are given access to the
    // entire node object in the render method.
    $entity = $values->_entity;

    // The node must have field_poster_path for this views field plugin to work.
    // Exit early if this field is unavailable or does not have a value.
    if(!$entity->hasField($field) || $entity->get($field)->isEmpty()) {
      return NULL;
    }

    // Get the image size from the field options setting.
    $size = $this->options['image_size'];

    // Get the value from the poster path field.
    $path = $entity->get($field)->getString();

    // Return a renderable element. In this case we are returning an image, but
    // a string or any other markup is also possible.
    return [
      '#theme' => 'image',
      '#uri' => "https://image.tmdb.org/t/p/{$size}{$path}",
      '#alt' => $entity->getTitle(),
    ];
  }

}
