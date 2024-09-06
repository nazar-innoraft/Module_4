<?php

namespace Drupal\movie_details\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures movie budget settings.
 */
class MovieDetailsConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'movie_details_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['movie_details.budget_settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('movie_details.budget_settings');

    $form['budget_amount'] = [
      '#type' => 'number',
      '#title' => $this->t('Budget Amount'),
      '#default_value' => $config->get('budget_amount') ?? 0,
      '#description' => $this->t('Enter the budget-friendly amount for movies.'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('movie_details.budget_settings')
      ->set('budget_amount', $form_state->getValue('budget_amount'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
