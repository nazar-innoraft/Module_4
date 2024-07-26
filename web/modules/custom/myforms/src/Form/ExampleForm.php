<?php

declare(strict_types=1);

namespace Drupal\myforms\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\RouteMatch;
use Symfony\Component\Validator\Constraints\IsNull;

/**
 * Provides a MyForms form.
 */
final class ExampleForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'myforms_example';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $node = \Drupal::RouteMatch()->getParameter('node');

    if (!is_null($node)) {
      $nid = $node->id();
    } else {
      $nid = 0;
    }

    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email address'),
      '#description' => 'We send an update to your email',
      '#required' => TRUE,
    ];

    $form['favorites']['colors'] = [
      '#type' => 'checkboxes',
      '#options' => ['blue' => $this->t('Blue'), 'red' => $this->t('Red')],
      '#title' => $this->t('Which colors do you likeWhich colors do you like?'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];

    $form['nid'] = [
      '#type' => 'hidden',
      '#value' => $nid,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->t('Nazar, form is working'));
  }

}
