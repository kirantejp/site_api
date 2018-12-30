<?php

namespace Drupal\site_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for Site API and Node validation.
 */
class SiteAPIController extends ControllerBase {
  private $siteAPIKey = '';

  /**
   * Constructor to get site API key.
   */
  public function __construct() {
    $site_config = \Drupal::config('system.site');
    $this->siteAPIKey = $site_config->get('siteapikey');
  }

  /**
   * Function to load content for valid node.
   */
  public function content($site_api, $nid) {

    // Validating both Site API ky and node type is matching with parameters.
    if (($this->siteAPIKey == $site_api) && ($nid->bundle() == "page")) {

      // Sending node title and node body as response.
      $response = ['title' => $nid->getTitle(), 'body' => $nid->body->view('full')];
    }
    else {

      // Access denied response if condition fails.
      $response = ['access denied' => 403];
    }
    return new JsonResponse($response);
  }

}
