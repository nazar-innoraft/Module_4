<?php

declare(strict_types=1);

namespace Drupal\movie\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\movie\Entity\Movie;

/**
 * Form controller for the movie entity edit forms.
 */
final class MovieForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {
    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => [Movie::class, 'load'],
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->get('title'),
      '#required' => TRUE,
    ];

    $form['movie_price'] = [
      '#type' => 'number',
      '#title' => $this->t('Movie price'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->get('movie_price'),
      '#required' => TRUE,
    ];

    $form['body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Body'),
      '#default_value' => $this->entity->get('body'),
    ];

    $form['image'] = [
      '#type' => 'image',
      '#title' => $this->t('Image'),
      '#default_value' => $this->entity->get('image'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $result = parent::save($form, $form_state);

    $message_args = ['%label' => $this->entity->toLink()->toString()];
    $logger_args = [
      '%label' => $this->entity->label(),
      'link' => $this->entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New movie %label has been created.', $message_args));
        $this->logger('movie')->notice('New movie %label has been created.', $logger_args);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The movie %label has been updated.', $message_args));
        $this->logger('movie')->notice('The movie %label has been updated.', $logger_args);
        break;

      default:
        throw new \LogicException('Could not save the entity.');
    }

    $form_state->setRedirectUrl($this->entity->toUrl());

    return $result;
  }
}
