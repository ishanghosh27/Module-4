<?php

namespace Drupal\movie_type\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\movie_type\MovieAwardInterface;

/**
 * Defines the Movie Award entity.
 *
 * @ConfigEntityType(
 *   id = "award",
 *   label = @Translation("Movie Award"),
 *   handlers = {
 *     "list_builder" = "Drupal\movie_type\Controller\MovieAwardListBuilder",
 *     "form" = {
 *       "add" = "Drupal\movie_type\Form\MovieAwardForm",
 *       "edit" = "Drupal\movie_type\Form\MovieAwardForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     }
 *   },
 *   config_prefix = "award",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "year" = "year",
 *     "movie" = "movie",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "year",
 *     "movie",
 *   },
 *   links = {
 *     "canonical" = "/admin/config/system/award/{award}",
 *     "collection" = "/admin/config/system/award",
 *     "add-form" = "/admin/config/system/award/add",
 *     "edit-form" = "/admin/config/system/award/{award}/edit",
 *     "delete-form" = "/admin/config/system/award/{award}/delete",
 *   }
 * )
 */
class MovieAward extends ConfigEntityBase implements MovieAwardInterface {

  /**
   * The Movie Award ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Movie Award label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Movie Award year.
   *
   * @var int
   */
  protected $year;

  /**
   * The Award Winning Movie.
   *
   * @var \Drupal\node\Entity\Node
   */
  protected $movie;

}
