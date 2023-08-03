<?php

namespace Drupal\manage_inventory;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a Inventory entity.
 *
 * @ingroup manage_inventory
 */
interface InventoryInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {
}
