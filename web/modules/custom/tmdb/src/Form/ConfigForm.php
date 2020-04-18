<?php

namespace Drupal\tmdb\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'tmdb.config',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('tmdb.config');
    $form['tmdb_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('TMDB API Key'),
      '#maxlength' => 256,
      '#size' => 64,
      '#default_value' => $config->get('tmdb_api_key'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('tmdb.config')
      ->set('tmdb_api_key', $form_state->getValue('tmdb_api_key'))
      ->save();
  }

}
