<?php

namespace Drupal\site_api\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Informing Drupal to use this route for Site Information settings form.
 */
class SiteApiRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('system.site_information_settings')) {
      $route->setDefault('_form', 'Drupal\site_api\Form\SiteAPIConfigForm');
    }
  }

}
