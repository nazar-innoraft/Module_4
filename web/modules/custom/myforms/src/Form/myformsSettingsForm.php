<?php

namespace Drupal\myforms\Form;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class myformsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
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
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('myforms.settings');

    $form['element'] = [
      '#type' => 'markup',
      '#markup' => '<div id="form-messages"></div>',
    ];

    $form['fullname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name :'),
      '#default_value' => $config->get('fullname'),
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

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::submitAjax',
        'wrapper' => 'form-messages',
      ],
    ];

    return $form;
  }

  /**
   * AJAX callback for form submission.
   */
  public function submitAjax(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $errors = $this->validateFormFields($form, $form_state);

    if (!empty($errors)) {
      // Display error messages.
      $error_messages = implode('<br>', $errors);
      $response->addCommand(new HtmlCommand('#form-messages', $error_messages));
    } else {
      // Save the configuration.
      $this->config('myforms.settings')
      ->set('fullname', $form_state->getValue('fullname'))
      ->set('phone', $form_state->getValue('phone'))
      ->set('email', $form_state->getValue('email'))
      ->set('gender', $form_state->getValue('gender'))
      ->save();

      // Display success message.
      $response->addCommand(new HtmlCommand('#form-messages', $this->t('Details saved successfully.')));
    }

    return $response;
  }

  protected function validateFormFields(array &$form, FormStateInterface $form_state) {
    $errors = [];

    $fullname = trim($form_state->getValue('fullname'));
    $phone = trim($form_state->getValue('phone'));
    $email = trim($form_state->getValue('email'));

    $pattern = '/^[A-Za-z]+(?:[. ][A-Za-z]+)*$/';
    if (empty($fullname)) {
      $errors[] = $this->t('Full Name cannot be empty.');
    } else {
      if (!preg_match($pattern, $fullname)) {
        $errors[] = $this->t('Name should only contains alpha, space and one dot');
      }
    }

    if (empty($phone) || !preg_match('/^[6-9]\d{9}$/', $phone)) {
      $errors[] = $this->t('Enter a valid 10-digit Indian phone number.');
    }

    if (empty($email)) {
      $errors[] = $this->t('The Email field cannot be empty.');
    } else {
      $pat = '/^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$/i';
      if (!preg_match($pat, $email)) {
        $errors[] = $this->t('Email not in correct format. Email must be from Gmail or Yahoo and end with .com.');
      }
    }

    return $errors;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // This method can be empty as the form submission is handled via AJAX.
  }
}
