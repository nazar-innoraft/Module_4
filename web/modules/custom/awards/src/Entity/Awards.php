<?php

declare(strict_types=1);

namespace Drupal\awards\Entity;

use Drupal\awards\AwardsInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the awards entity class.
 *
 * @ContentEntityType(
 *   id = "awards",
 *   label = @Translation("Awards"),
 *   label_collection = @Translation("Awardss"),
 *   label_singular = @Translation("awards"),
 *   label_plural = @Translation("awardss"),
 *   label_count = @PluralTranslation(
 *     singular = "@count awardss",
 *     plural = "@count awardss",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\awards\AwardsListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\awards\Form\AwardsForm",
 *       "edit" = "Drupal\awards\Form\AwardsForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *       "revision-delete" = \Drupal\Core\Entity\Form\RevisionDeleteForm::class,
 *       "revision-revert" = \Drupal\Core\Entity\Form\RevisionRevertForm::class,
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *       "revision" = \Drupal\Core\Entity\Routing\RevisionHtmlRouteProvider::class,
 *     },
 *   },
 *   base_table = "awards",
 *   data_table = "awards_field_data",
 *   revision_table = "awards_revision",
 *   revision_data_table = "awards_field_revision",
 *   show_revision_ui = TRUE,
 *   translatable = TRUE,
 *   admin_permission = "administer awards",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "name"="name",
 *     "year"="year",
 *     "langcode" = "langcode",
 *     "description"="description"
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_uid",
 *     "revision_created" = "revision_timestamp",
 *     "revision_log_message" = "revision_log",
 *   },
 *   links = {
 *     "collection" = "/admin/content/awards",
 *     "add-form" = "/admin/structure/awards/add",
 *     "canonical" = "/admin/structure/awards/{awards}",
 *     "edit-form" = "/admin/structure/awards/{awards}/edit",
 *     "delete-form" = "/admin/structure/awards/{awards}/delete",
 *     "delete-multiple-form" = "/admin/content/awards/delete-multiple",
 *     "revision" = "/admin/structure/awards/{awards}/revision/{awards_revision}/view",
 *     "revision-delete-form" = "/admin/structure/awards/{awards}/revision/{awards_revision}/delete",
 *     "revision-revert-form" = "/admin/structure/awards/{awards}/revision/{awards_revision}/revert",
 *     "version-history" = "/admin/structure/awards/{awards}/revisions",
 *   },
 *   field_ui_base_route = "entity.awards.settings",
 *   config_export = {
 *     "id",
 *     "label",
 *     "name",
 *     "year",
 *     "description",
 *   },
 * )
 */
final class Awards extends RevisionableContentEntityBase implements AwardsInterface {

  /**
   * The example ID.
   */
  protected string $id;

  /**
   * The example label.
   */
  protected string $label;

  /**
   * The example name.
   */
  protected string $name;

  /**
   * The example year.
   */
  protected int $year;

  /**
   * The example description.
   */
  protected string $description;
}
