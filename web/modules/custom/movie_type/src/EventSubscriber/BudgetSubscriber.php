<?php

namespace Drupal\movie_type\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Subscribes to the Budget Event.
 *
 * @package Drupal\movie_type\EventSubscriber
 */
class BudgetSubscriber implements EventSubscriberInterface {

  /**
   * Stores the \Drupal\Core\Messenger\MessengerInterface object.
   *
   * @var object
   */
  protected $message;

  /**
   * Stores the \Drupal\Core\Config\ConfigFactoryInterface object.
   *
   * @var object
   */
  protected $configFactory;

  /**
   * Stores ContainerAwareEventDispatcher object.
   *
   * @var object
   */
  protected $dispatchEvent;

  /**
   * Initializes the MessengerInterface class.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $message
   *   Stores the object of the MessengerInterface class.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Stores the object of the ConfigFactoryInterface class.
   */
  public function __construct(MessengerInterface $message, ConfigFactoryInterface $config_factory) {
    $this->message = $message;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(($container->get('messenger')), ($container->get('config.factory')));
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [];
    $events[KernelEvents::REQUEST][] = ['onNodeView', 30];
    return $events;
  }

  /**
   * Subscribe to the Budget Event.
   *
   * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
   *   Our budget event object.
   */
  public function onNodeView(RequestEvent $event) {
    $request = $event->getRequest();
    $attributes = $request->attributes;
    $node = $attributes->get('node');
    if ($node instanceof NodeInterface) {
      $bundle = $node->bundle();
      if ($bundle === 'movie_type') {
        if ($node->hasField('field_movie_price')) {
          $config = $this->configFactory->get('movie_budget.admin_settings');
          $budget = $config->get('budget');
          if (!empty($budget)) {
            $price = $node->get('field_movie_price');
            if (!$node->get('field_movie_price')->isEmpty()) {
              $price_value = $price->getValue()[0]['value'];
              if ($price_value > $budget) {
                $message = 'The movie is over budget!';
              }
              else {
                if ($price_value < $budget) {
                  $message = 'The movie is under budget!';
                }
                else {
                  if ($price_value = $budget) {
                    $message = 'The movie is within budget!';
                  }
                }
              }
              $this->message->addStatus('Event Task - ' . $message);
            }
          }
        }
      }
    }
  }

}
