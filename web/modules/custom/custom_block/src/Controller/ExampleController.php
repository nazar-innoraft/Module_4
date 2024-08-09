<?php

declare(strict_types=1);

namespace Drupal\custom_block\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Returns responses for Custom block routes.
 */
final class ExampleController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {

    $build['content'] = [
      '#markup' => $this->t('This is the custom page content.'),
    ];

    return $build;
  }

  public function checkLoggedIn() {
    // return new RedirectResponse(\Drupal::url('custom_block.example'));
    return $this->redirect('/custom_block.example');
  }
}
