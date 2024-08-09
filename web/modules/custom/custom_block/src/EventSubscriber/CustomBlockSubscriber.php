<?php

namespace Drupal\custom_redirect\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribes to the kernel request event to perform redirection.
 */
class CustomBlockSubscriber implements EventSubscriberInterface {

  /**
   * Redirects users based on certain conditions.
   *
   * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
   * The event to process.
   */
  public function onKernelRequest(RequestEvent $event) {
    $request = $event->getRequest();
    $current_path = $request->getPathInfo();

    $pat = '/user/2?check_logged_in=1';
    if ($current_path === $pat && \Drupal::currentUser()->isAuthenticated()) {
      $response = new RedirectResponse('/custom-welcome-page');
      $event->setResponse($response);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['onKernelRequest', 0];
    return $events;
  }
}
