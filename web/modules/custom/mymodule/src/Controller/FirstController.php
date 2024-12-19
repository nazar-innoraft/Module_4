<?php

namespace Drupal\mymodule\Controller;

use Drupal\user\Entity\User;
use Drupal\Core\Controller\ControllerBase;

/**
 * FirstController is the main controller class.
 */
class FirstController extends ControllerBase {
  private $user;
  private $name;

  /**
   * SimpleContent function view a page.
   *
   * @return array
   */
  public function simpleContent(): array {
    return [];
  }

  /**
   * Test function view a page and hello to user.
   *
   * @return array
   */
  public function test(): array {
    $this->user = User::load(\Drupal::currentUser()->id());
    $this->name = $this->user->get('name')->value;
    return [
      '#type' => 'markup',
      '#markup' => t('Hello, ' . strtolower($this->name) . '<br>How are you?')
    ];
  }
}

