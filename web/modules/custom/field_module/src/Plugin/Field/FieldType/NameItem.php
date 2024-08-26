<?php

declare(strict_types=1);

namespace Drupal\field_module\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'field_module_name' field type.
 *
 * @FieldType(
 *   id = "field_module_type",
 *   label = @Translation("Name"),
 *   description = @Translation("Some description."),
 *   default_widget = "field_module_name",
 *   default_formatter = "field_module_custom_field_formatter",
 * )
 */
class NameItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return match ($this->get('value')->getValue()) {
      NULL, '' => TRUE,
      default => FALSE,
    };
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    // @DCG
    // See /core/lib/Drupal/Core/TypedData/Plugin/DataType directory for
    // available data types.
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Text value'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {

    $columns = [
      'value' => [
        'type' => 'varchar',
        'not null' => FALSE,
        'description' => 'Column description.',
        'length' => $field_definition->getSetting('length'),
      ],
    ];

    $schema = [
      'columns' => $columns,
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'length' => 255,
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $element = [];
    $element['length'] = [
      '#type' => 'number',
      '#title' => t("Length of your text"),
      '#default_value' => $this->getSetting('length'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultFeildSettings() {
    return [
      'morein' => 'More information info'
    ] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = [];
    $element['morein'] = [
      '#type' => 'textfield',
      '#title' => t("More information"),
      '#required' => TRUE,
      '#default_value' => $this->getSetting('morein'),
    ];

    return $element;
  }
}
