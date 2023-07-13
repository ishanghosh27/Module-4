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
      $route->setPath('/altered-dynamic-routing/{param_1}/{param_2}');
      $route->setDefault('_controller', '\Drupal\dynamic_routing_one\Controller\DynamicRouting::content');
      $collection->add('dynamic_routing_one.dynamic_route', $route);
    }

  }

?>
