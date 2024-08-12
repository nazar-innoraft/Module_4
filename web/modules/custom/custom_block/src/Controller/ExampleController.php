<?php

declare(strict_types=1);

namespace Drupal\custom_block\Controller;

use Drupal\Core\Controller\ControllerBase;

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
}
