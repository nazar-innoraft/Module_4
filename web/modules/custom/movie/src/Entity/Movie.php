<?php

declare(strict_types=1);

namespace Drupal\movie\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\movie\MovieInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the movie entity class.
 *
 * @ContentEntityType(
 *   id = "movie",
 *   label = @Translation("Movie"),
 *   label_collection = @Translation("Movies"),
 *   label_singular = @Translation("movie"),
 *   label_plural = @Translation("movies"),
 *   label_count = @PluralTranslation(
 *     singular = "@count movies",
 *     plural = "@count movies",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\movie\MovieListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\movie\Form\MovieForm",
 *       "edit" = "Drupal\movie\Form\MovieForm",
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
 *   base_table = "movie",
 *   data_table = "movie_field_data",
 *   revision_table = "movie_revision",
 *   revision_data_table = "movie_field_revision",
 *   show_revision_ui = TRUE,
 *   translatable = TRUE,
 *   admin_permission = "administer movie",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "revision_id",
 *     "langcode" = "langcode",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_uid",
 *     "revision_created" = "revision_timestamp",
 *     "revision_log_message" = "revision_log",
 *   },
 *   links = {
 *     "collection" = "/admin/content/movie",
 *     "add-form" = "/admin/structure/movie/add",
 *     "canonical" = "/admin/structure/movie/{movie}",
 *     "edit-form" = "/admin/structure/movie/{movie}/edit",
 *     "delete-form" = "/admin/structure/movie/{movie}/delete",
 *     "delete-multiple-form" = "/admin/content/movie/delete-multiple",
 *     "revision" = "/admin/structure/movie/{movie}/revision/{movie_revision}/view",
 *     "revision-delete-form" = "/admin/structure/movie/{movie}/revision/{movie_revision}/delete",
 *     "revision-revert-form" = "/admin/structure/movie/{movie}/revision/{movie_revision}/revert",
 *     "version-history" = "/admin/structure/movie/{movie}/revisions",
 *   },
 *   field_ui_base_route = "entity.movie.settings",
 * )
 */
final class Movie extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {

    $fields = parent::baseFieldDefinitions($entity_type);

    // Title field
    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of the movie.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Body field
    $fields['body'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Body'))
      ->setDescription(t('A description of the movie.'))
      ->setSettings([
        'default_value' => '',
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Movie price field
    $fields['movie_price'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Movie Price'))
      ->setDescription(t('The price of the movie.'))
      ->setSettings([
        'precision' => 10,
        'scale' => 2,
        'prefix' => '₹ ',
      ])
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Image field
    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Image'))
      ->setDescription(t('The cover image of the movie.'))
      ->setDisplayOptions('form', [
        'type' => 'image_image',
        'weight' => 2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }
}
