<?php

declare(strict_types=1);

namespace Drupal\movie;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the movie entity type.
 */
final class MovieListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['id'] = $this->t('ID');
    $header['title'] = $this->t('Title');
    $header['body'] = $this->t('Body');
    $header['movie_price'] = $this->t('Movie Price');
    $header['image'] = $this->t('Image');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\entity_module\Entity\EntityModule $entity */
    $row['id'] = $entity->id();
    $row['title'] = $entity->label();
    $row['body'] = $entity->get('body')->value;
    $row['movie_price'] = $entity->get('movie_price')->value;
    if ($file = $entity->get('image')->entity) {
      // Use the toUrl() method to get the URL of the file.
      $url = $file->toUrl()->toString();
      $row['image'] = $url;
    } else {
      $row['image'] = "";
    }
    return $row + parent::buildRow($entity);
  }

}
