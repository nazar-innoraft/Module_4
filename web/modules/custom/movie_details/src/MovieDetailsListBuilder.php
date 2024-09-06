<?php

declare(strict_types=1);

namespace Drupal\movie_details;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the movie details entity type.
 */
final class MovieDetailsListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['id'] = $this->t('ID');
    $header['title'] = $this->t('Title');
    $header['movie_price'] = $this->t('Movie Price');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\movie_details\MovieDetailsInterface $entity */
    $row['id'] = $entity->id();
    $row['title'] = $entity->label();
    $row['movie_price'] = $entity->get('movie_price')->value;
    // if ($file = $entity->get('image')->entity) {
    //   // Use the toUrl() method to get the URL of the file.
    //   $url = $file->toUrl()->toString();
    //   $row['image'] = $url;
    // } else {
    //   $row['image'] = "";
    // }
    return $row + parent::buildRow($entity);
  }

  // /**
  //  * {@inheritdoc}
  //  */
  // public function buildHeader(): array {
  //   $header['id'] = $this->t('ID');
  //   return $header + parent::buildHeader();
  // }

  // /**
  //  * {@inheritdoc}
  //  */
  // public function buildRow(EntityInterface $entity): array {
  //   /** @var \Drupal\movie_details\MovieDetailsInterface $entity */
  //   $row['id'] = $entity->toLink();
  //   return $row + parent::buildRow($entity);
  // }

}
