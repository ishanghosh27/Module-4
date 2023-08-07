<?php

namespace Drupal\movie_type\Event;

use Drupal\Component\EventDispatcher\Event;
use Drupal\Core\Routing\CurrentRouteMatch;

/**
 * Event that is fired when a user visits the movie_type content node(s).
 */
class BudgetEvent extends Event {

  const EVENT_NAME = 'movie_budget_event';

  /**
   * The user account.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  public $routeMatch;

  /**
   * Constructs the object.
   *
   * @param \Drupal\Core\Routing\CurrentRouteMatch $route_match
   *   The account of the user logged in.
   */
  public function __construct(CurrentRouteMatch $route_match) {
    $this->routeMatch = $route_match;
  }

  /**
   * Method to return the current route name.
   *
   * @return object
   *   Returns the current route name.
   */
  public function getRouteMatch() {
    return $this->routeMatch;
  }

}
