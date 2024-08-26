<?php

namespace Drupal\field_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\WidgetInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Defines the 'field_module_name_hex' field Widget.
 *
 * @FieldWidget(
 *   id = "field_module_name_hex",
 *   label = @Translation("Cusmtom widget HEX"),
 *   description = @Translation("Some description"),
 *   field_types = {
 *    "field_module_type"
 *   }
 * )
 */
class FieldModuleHEXWidget extends WidgetBase implements WidgetInterface{

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $element += [
      '#type' => 'textfield',
      '#default_value' => $value,
      '#attributes' => [
        'placeholder' => $this->getSetting('placeholder')
      ],
      '#size' => 7,
      '#maxlength' => 7,
      '#element_validate' => [
        [static::class, 'validate'],
      ],
    ];

    return [
      'value' => $element
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function validate($element, FormStateInterface $form_state) {
    $value = $element['#value'];
    if (strlen($value) == 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
    if (!preg_match('/^#([a-f0-9]{6})$/iD', strtolower($value))) {
      $form_state->setError($element, t("Color must be a 6-digit hexadecimal value, suitable for CSS With # at begining."));
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'placeholder' => '#FFFFFF',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['placeholder'] = [
      '#type' => 'textfield',
      '#title' => 'For placeholder',
      '#default_value' => $this->getSetting('placeholder'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    return [$this->t("Placeholder text : @placeholder" , ['@placeholder' => $this->getSetting('placeholder')])];
  }
}
