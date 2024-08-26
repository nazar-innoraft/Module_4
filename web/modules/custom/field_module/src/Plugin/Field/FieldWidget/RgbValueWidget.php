<?php

namespace Drupal\field_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'field_module_rgb_value' field widget.
 *
 * @FieldWidget(
 *   id = "field_module_rgb_value",
 *   label = @Translation("RGB value"),
 *   field_types = {
 *    "field_module_type"
 *   }
 * )
 */
final class RgbValueWidget extends WidgetBase
{

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array
  {
    $setting = ['r' => 0];
    $setting = ['g' => 0];
    $setting = ['b' => 0];
    return $setting + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array
  {
    $element['r'] = [
      '#type' => 'num',
      '#title' => $this->t('Red'),
      '#default_value' => $this->getSetting('red'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array
  {
    return [
      $this->t('Foo: @foo', ['@foo' => $this->getSetting('foo')]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array
  {
    $element['red'] = [
      '#type' => 'number',
      '#title' => t('Red'),
      '#default_value' => $items[$delta]->value ?? NULL,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['green'] = [
      '#type' => 'number',
      '#title' => t('Green'),
      '#default_value' => $items[$delta]->value ?? NULL,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['blue'] = [
      '#type' => 'number',
      '#title' => t('Blue'),
      '#default_value' => $items[$delta]->value ?? NULL,
      '#min' => 0,
      '#max' => 255,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state)
  {
    foreach ($values as &$value) {
      // Assuming the form has 'red', 'green', and 'blue' as form elements.
      $r = $value['red'];
      $g = $value['green'];
      $b = $value['blue'];

      // Convert RGB to Hex.
      $value['value'] = $this->rgbToHex($r, $g, $b);

      // You can unset RGB values if you no longer need them.
      unset($value['red'], $value['green'], $value['blue']);
    }

    return $values;
  }

  /**
   * Converts RGB to Hex.
   *
   * @param int $r
   *   The red component (0-255).
   * @param int $g
   *   The green component (0-255).
   * @param int $b
   *   The blue component (0-255).
   *
   * @return string
   *   The hex color code, e.g., '#FF5733'.
   */
  private function rgbToHex(int $r, int $g, int $b): string
  {
    // Ensure the values are within the 0-255 range.
    $r = max(0, min(255, $r));
    $g = max(0, min(255, $g));
    $b = max(0, min(255, $b));

    // Convert each component to hex and pad with zeros if needed.
    return sprintf("#%02X%02X%02X", $r, $g, $b);
  }
}
