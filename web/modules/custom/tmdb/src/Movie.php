<?php

namespace Drupal\tmdb;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Http\ClientFactory;
use GuzzleHttp\Client;

class Movie {

  /**
   * Guzzle HTTP client.
   * 
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * Module configuration object.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Movie constructor.
   *
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   */
  public function __construct(ClientFactory $http_client_factory, ConfigFactory $configFactory) {
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'https://api.themoviedb.org/3',
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
    $response = $this->client->get("movie/{$id}", [
      'query' => [
        'api_key' => $this->config->get('tmdb_api_key'),
      ]
    ]);
    return Json::decode($response->getBody());
  }

}
