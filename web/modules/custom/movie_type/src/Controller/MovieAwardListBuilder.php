<?php

namespace Drupal\movie_type\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of Movie Award.
 */
class MovieAwardListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Movie Award');
    $header['year'] = $this->t('Year');
    $header['movie'] = $this->t('Movie');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $entity->label();
    $row['year'] = $entity->get('year');
    $movie_id = $entity->get('movie') ?? '';
    if (!empty($movie_id)) {
      $movie_name = \Drupal::entityTypeManager()->getStorage('node')->load($movie_id);
      $row['movie'] = $movie_name ? $movie_name->toLink() : '';
    }
    else {
      $row['movie'] = '';
    }
    return $row + parent::buildRow($entity);
  }

}
