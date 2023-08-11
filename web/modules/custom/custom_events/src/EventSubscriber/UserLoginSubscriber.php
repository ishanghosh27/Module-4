<?php

namespace Drupal\custom_events\EventSubscriber;

use Drupal\Core\Database\Connection;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\custom_events\Event\UserLoginEvent;
use Drupal\movie_type\Event\BudgetEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribes to the Login Event.
 *
 * @package Drupal\custom_events\EventSubscriber
 */
class UserLoginSubscriber implements EventSubscriberInterface {

  /**
   * Stores the \Drupal\Core\Messenger\MessengerInterface object.
   *
   * @var object
   */
  protected $message;

  /**
   * Stores the \Drupal\Core\Database\Connection object.
   *
   * @var object
   */
  protected $database;

  /**
   * Stores the \Drupal\Core\Datetime\DateFormatterInterface object.
   *
   * @var object
   */
  protected $dateFormatter;

  /**
   * Initializes the MessengerInterface class.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $message
   *   Stores the object of the MessengerInterface class.
   * @param \Drupal\Core\Database\Connection $database
   *   Stores the object of the Connection class.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $dateFormatter
   *   Stores the object of the DateFormatterInterface class.
   */
  public function __construct(MessengerInterface $message, Connection $database, DateFormatterInterface $dateFormatter) {
    $this->message = $message;
    $this->database = $database;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('messenger'), ($container->get('database')), ($container->get('date.formatter')));
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      // Static class constant => method on this class.
      UserLoginEvent::EVENT_NAME => ['onUserLogin', 800],
    ];
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\custom_events\Event\UserLoginEvent $event
   *   Our custom event object.
   */
  public function onUserLogin(UserLoginEvent $event) {
    $account_created = $this->database->select('users_field_data', 'ud')
      ->fields('ud', ['created'])
      ->condition('ud.uid', $event->account->id())
      ->execute()
      ->fetchField();
    $this->message->addStatus(t('Welcome, your account was created on %created_date.', [
      '%created_date' => $this->dateFormatter->format($account_created, 'short'),
    ]));
  }

}
