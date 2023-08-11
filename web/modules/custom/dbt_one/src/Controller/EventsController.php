<?php

namespace Drupal\dbt_one\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This class returns a basic page with the events dashboard.
 */
class EventsController extends ControllerBase {

  /**
   * Stores the database connection.
   *
   * @var object
   */
  protected $connection;

  /**
   * This method initializes the database connection.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   Stores the object of the Connection class - database connection.
   */
  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('database'));
  }

  /**
   * This method returns a page with the events dashboard.
   *
   * @return array
   *   The render array for the page.
   */
  public function eventsDashboard() {
    $query_one = "SELECT YEAR(events_date_value) AS event_year, COUNT(*) AS event_year_count
              FROM node__events_date
              GROUP BY YEAR(events_date_value)
              ORDER BY event_year";
    $result_one = $this->connection->query($query_one)->fetchAll();
    $query_two = "SELECT YEAR(events_date_value) AS event_year, QUARTER(events_date_value) AS event_quarter, COUNT(*) AS event_quarter_count
              FROM node__events_date
              GROUP BY YEAR(events_date_value), QUARTER(events_date_value)
              ORDER BY event_year, event_quarter";
    $result_two = $this->connection->query($query_two)->fetchAll();
    $query_three = "SELECT events_type_value AS event_type, COUNT(*) AS event_count
              FROM node__events_type
              GROUP BY events_type_value";
    $result_three = $this->connection->query($query_three)->fetchAll();
    return [
      '#theme' => 'events_dashboard',
      '#yearly' => $result_one,
      '#quarterly' => $result_two,
      '#types' => $result_three,
      '#attached' => [
        'library' => [
          'dbt_one/events-dashboard',
        ],
      ],
      '#cache' => [
        'tags' => [
          'node_list:dbt_one',
        ],
      ],
    ];
  }

}
