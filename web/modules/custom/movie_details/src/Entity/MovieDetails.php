<?php

declare(strict_types=1);

namespace Drupal\movie_details\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Form\RevisionDeleteForm;
use Drupal\Core\Entity\Form\RevisionRevertForm;
use Drupal\movie_details\MovieDetailsInterface;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Entity\Routing\RevisionHtmlRouteProvider;

/**
 * Defines the movie details entity class.
 *
 * @ContentEntityType(
 *   id = "movie_details",
 *   label = @Translation("Movie details"),
 *   label_collection = @Translation("Movie detailss"),
 *   label_singular = @Translation("movie details"),
 *   label_plural = @Translation("movie detailss"),
 *   label_count = @PluralTranslation(
 *     singular = "@count movie detailss",
 *     plural = "@count movie detailss",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\movie_details\MovieDetailsListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\movie_details\Form\MovieDetailsForm",
 *       "edit" = "Drupal\movie_details\Form\MovieDetailsForm",
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
 *   base_table = "movie_details",
 *   revision_table = "movie_details_revision",
 *   show_revision_ui = TRUE,
 *   admin_permission = "administer movie_details",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "revision_id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_uid",
 *     "revision_created" = "revision_timestamp",
 *     "revision_log_message" = "revision_log",
 *   },
 *   links = {
 *     "collection" = "/admin/content/movie-details",
 *     "add-form" = "/admin/structure/movie-details/add",
 *     "canonical" = "/admin/structure/movie-details/{movie_details}",
 *     "edit-form" = "/admin/structure/movie-details/{movie_details}/edit",
 *     "delete-form" = "/admin/structure/movie-details/{movie_details}/delete",
 *     "delete-multiple-form" = "/admin/content/movie-details/delete-multiple",
 *     "revision" = "/admin/structure/movie-details/{movie_details}/revision/{movie_details_revision}/view",
 *     "revision-delete-form" = "/admin/structure/movie-details/{movie_details}/revision/{movie_details_revision}/delete",
 *     "revision-revert-form" = "/admin/structure/movie-details/{movie_details}/revision/{movie_details_revision}/revert",
 *     "version-history" = "/admin/structure/movie-details/{movie_details}/revisions",
 *   },
 *   field_ui_base_route = "entity.movie_details.settings",
 * )
 */
final class MovieDetails extends RevisionableContentEntityBase implements MovieDetailsInterface {
  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array
  {

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
    ->setLabel(t('Description'))
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
