<?php

declare(strict_types=1);

namespace Drupal\campaign\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Campaign routes.
 */
final class CampaignController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke($num): array {

    $res = '';
    if (is_numeric($num)) {
      $res = $this->t('Dear friend you have entered -----<h1><strong>' . $num . '</strong></h1>');
    } else {
      $res = $this->t('Dear friend you have entered a not numeric value, please change this ----- <strong>' . $num . '</strong>');
    }

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $res,
    ];

    return $build;
  }
}
