<?php

namespace Drupal\dbt_one;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleUninstallValidatorInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

/**
 * Prevents dbt_one module from being uninstalled under certain conditions.
 *
 * These conditions are when any dbt_one nodes exist or there are any
 * dbt_one.
 */
class EventsUninstallValidator implements ModuleUninstallValidatorInterface {

  use StringTranslationTrait;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new EventsUninstallValidator.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
   *   The string translation service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, TranslationInterface $string_translation) {
    $this->entityTypeManager = $entity_type_manager;
    $this->stringTranslation = $string_translation;
  }

  /**
   * {@inheritdoc}
   */
  public function validate($module) {
    $reasons = [];
    if ($module === 'dbt_one' && $this->hasEventsNodes() != 0) {
      $reasons[] = $this->t('In Order To uninstall Events Type Module, First Delete All
      Content Of This Type.');
    }
    return $reasons;
  }

  /**
   * Determines if there is any dbt_one nodes or not.
   *
   * @return bool
   *   TRUE if there are dbt_one nodes, FALSE otherwise.
   */
  protected function hasEventsNodes() {
    $nodes = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'dbt_one')
      ->accessCheck(FALSE)
      ->range(0, 1)
      ->execute();
    return !empty($nodes);
  }

}
