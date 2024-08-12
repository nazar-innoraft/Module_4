<?php

namespace Drupal\custom_block\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a Custom block.
 *
 * @Block(
 *   id = "custom_block_1",
 *   admin_label = @Translation("Custom Block"),
 *   category = @Translation("Nazar"),
 * )
 */
class CustomBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $account;
  protected $message;

  /**
   * @param  Drupal\Core\Session\AccountInterface
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    protected AccountInterface $currentUser,
    MessengerInterface $messageInterface,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->account = $currentUser;
    $this->message = $messageInterface;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('messenger'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'pretext' => $this->t('Welcome,'),
      'posttext' => $this->t('How are you?'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    $form['pretext'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Pre Text'),
      '#default_value' => $this->configuration['pretext'],
    ];
    $form['posttext'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Post Text'),
      '#default_value' => $this->configuration['posttext'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    $this->configuration['pretext'] = $form_state->getValue('pretext');
    $this->configuration['posttext'] = $form_state->getValue('posttext');
    $this->message->addStatus(t('Hey hero your data succesfully saved'));
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $user = $this->account->getDisplayName();

    $build['content'] = [
      '#markup' => $this->t($this->configuration['pretext'] . '<b> @name </b>' . $this->configuration['posttext'], ['@name'=> strtoupper($user)]),
    ];
    return $build;
  }
}
