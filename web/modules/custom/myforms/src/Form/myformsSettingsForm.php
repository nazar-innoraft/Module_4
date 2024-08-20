<?php

namespace Drupal\myforms\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class myformsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'myforms_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return [
      'myforms.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('myforms.settings');

    $form['fullname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name :'),
      '#default_value' => $config->get('fullname')
    ];

    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Enter Phone Number :'),
      '#pattern' => '^[6-9]\d{9}$',
      '#default_value' => $config->get('phone'),
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email :'),
      // '#pattern' => '^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$',
      '#default_value' => $config->get('email'),
    ];

    $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Select your gender :'),
      '#default_value' => $config->get('gender'),
      '#options' => [
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'DND' => $this->t('Do not want to disclose'),
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $value = trim($form_state->getValue('email'));
    $pat = '/^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$/i';
    if (!preg_match($pat, $value)) {
      $form_state->setErrorByName('email', 'Email not in correct format. Email is from the public domain(like Yahoo, Gmail, Outlook etc or not) and ends with .com also');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('myforms.settings')
      ->set('fullname', $form_state->getValue('fullname'))
      ->set('phone', $form_state->getValue('phone'))
      ->set('email', $form_state->getValue('email'))
      ->set('gender', $form_state->getValue('gender'))
      ->save();
    \Drupal::messenger()->addMessage('Deatil saved successfully');
  }
}
