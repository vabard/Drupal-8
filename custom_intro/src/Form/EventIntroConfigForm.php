<?php

namespace Drupal\custom_intro\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class EventIntroConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'event_intro_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom_intro.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_intro.settings');

    $form['text']['#markup'] = t('<span class="advertiser">Attention, cliquer sur "Retirer" un média est irréversible et la suppression est immédiate.</span>');

    $form['intro_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Titre, 25 caractères max'),
      '#maxlength' => 25,
      '#size' => 25,
      '#weight' => '0',
      '#default_value' => $config->get('intro_title'),
    ];
    $form['intro_background_image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Visuel desktop de fond en format png uniquement, résolution optimale : 1920x1080px, 2 Mo'),
      '#upload_location' => 'public://introduction/',
      '#weight' => '0',
      '#upload_validators' => [
        'file_validate_extensions' => ['png'],
        'file_validate_size' => [2000000],
      ],
      '#default_value' => $config->get('intro_background_image'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Retrieve the configuration
    $this->configFactory->getEditable('custom_intro.settings')

      // Set the submitted configuration setting
      ->set('intro_title', $form_state->getValue('intro_title'))
      ->set('intro_background_image', $form_state->getValue('intro_background_image'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
