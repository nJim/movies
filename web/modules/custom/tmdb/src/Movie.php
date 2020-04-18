<?php

namespace Drupal\tmdb;

use Drupal\Component\Serialization\Json;

class Movie {

  /**
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * Movie constructor.
   *
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   */
  public function __construct($http_client_factory) {
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'https://api.themoviedb.org/',
    ]);
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
    $response = $this->client->get("3/movie/{$id}", [
      'query' => [
        'api_key' => '',
      ]
    ]);
    return Json::decode($response->getBody());
  }

}