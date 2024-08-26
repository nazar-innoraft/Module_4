<?php

namespace Drupal\field_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Defines the 'field_module_name' field Widget.
 *
 * @FieldWidget(
 *   id = "field_module_name",
 *   label = @Translation("Cusmtom widget"),
 *   description = @Translation("Some description"),
 *   field_types = {
 *    "field_module_type"
 *   }
 * )
 */
class FieldModuleWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $element = $element + [
      '#type' => 'color',
      '#suffix' => '<span>' . $this->getFieldSetting('morein') . '</span>',
      '#dafault_value' => $value,
    ];

    return [
      'value' => $element
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    return [$this->t("Placeholder text : @placeholder" , ['@placeholder' => $this->getSetting('placeholder')])];
  }
}
