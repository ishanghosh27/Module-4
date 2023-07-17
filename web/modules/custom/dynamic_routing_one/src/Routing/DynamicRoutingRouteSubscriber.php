<?php

namespace Drupal\dynamic_routing_one\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * This class alters the previously defined dynamic route of a route collection.
 */
class DynamicRoutingRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    $route = $collection->get('dynamic_routing_one.dynamic_route');
    $route->setPath('/altered-dynamic-routing/{para_1}/{para_2}');
  }

}
