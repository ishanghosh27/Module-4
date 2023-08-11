<?php

namespace Drupal\custom_events\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class EntityTypeSubscriber.
 *
 * @package Drupal\custom_events\EventSubscriber
 */
class AnotherConfigEventsSubscriber implements EventSubscriberInterface {

  /**
   * Stores the \Drupal\Core\Messenger\MessengerInterface object.
   *
   * @var object
   */
  protected $message;

  /**
   * Initializes the MessengerInterface class.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $message
   *   Stores the object of the MessengerInterface class.
   */
  public function __construct(MessengerInterface $message) {
    $this->message = $message;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('messenger'));
  }

  /**
   * {@inheritdoc}
   *
   * @return array
   *   The event names to listen for, and the methods that should be executed.
   */
  public static function getSubscribedEvents() {
    return [
      ConfigEvents::SAVE => ['configSave', 100],
      ConfigEvents::DELETE => ['configDelete', -100],
    ];
  }

  /**
   * React to a config object being saved.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   Config crud event.
   */
  public function configSave(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    $this->message->addStatus('(Another) Saved config: ' . $config->getName());
  }

  /**
   * React to a config object being deleted.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   Config crud event.
   */
  public function configDelete(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    $this->message->addStatus('(Another) Deleted config: ' . $config->getName());
  }

}
