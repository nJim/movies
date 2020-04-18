<?php

namespace Drupal\tmdb;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Http\ClientFactory;

class Client {

  /**
   * Guzzle HTTP client.
   * 
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * Configuration object for TMDB settings.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Constructor.
   *
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   *   Contructing HTTP client.
   * @param $configFactory \Drupal\Core\Config\ConfigFactory
   *   Access config objects.
   */
  public function __construct(ClientFactory $http_client_factory, ConfigFactory $configFactory) {
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'https://api.themoviedb.org/3/',
    ]);
    $this->config = $configFactory->get('tmdb.config');
  }

  /**
   * Get the primary information about a movie.
   * 
   * @param integer $id
   *   The movie id within tmdb.
   * 
   * @return object
   *   The JSON response decoded to an object.
   */
  public function getMovie($id = '9607') {
    $response = $this->get("movie/{$id}");
    return Json::decode($response->getBody());
  }

  /**
   * Request data from TMDB API.
   * 
   * @todo: Check response codes and add error handling.
   * 
   * @param string $endpoint
   *   The complete path of TMDB endpoint.
   * 
   * @return GuzzleHttp\Psr7\Response
   *   Response object.
   */
  protected function get($endpoint) {
    return $this->client->get($endpoint, [
      'query' => [
        'api_key' => $this->config->get('tmdb_api_key'),
      ]
    ]);
  }

}
