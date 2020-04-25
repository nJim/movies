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
   * Guzzle response object.
   *
   * @var GuzzleHttp\Psr7\Response
   */
  protected $response;

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
      'base_uri' => 'https://api.themoviedb.org/',
    ]);
    $this->config = $configFactory->get('tmdb.config');
  }

  /**
   * Fetch the primary information about a movie.
   * 
   * @param integer $id
   *   The movie id within tmdb.
   * 
   * @return object
   *   The JSON response decoded to an object.
   */
  public function fetchMovie($id) {
    return $this->fetch("3/movie/{$id}");
  }

  /**
   * Fetch the movies from a list.
   * 
   * @todo: Check that a non empty list is returned.
   * 
   * @param integer $id
   *   The list id within tmdb.
   * 
   * @return array
   *   An array of movie objects.
   */
  public function getMoviesFromList($id = '139830') {
    return $this->fetchList($id)['items'];
  }

  /**
   * Fetch the primary information about a collection of movies.
   * 
   * @param integer $id
   *   The list id within tmdb.
   * 
   * @return object
   *   The JSON response decoded to an object.
   */
  protected function fetchList($id) {
    return $this->fetch("3/list/{$id}");
  }

  /**
   * Fetch the cast credits for a movie.
   * 
   * @param integer $id
   *   The movie id within tmdb.
   * 
   * @return array
   *   An array of credit objects.
   */
  public function fetchMovieCastCredits($id) {
    return $this->fetchMovieCredits($id)['cast'];
  }

  /**
   * Fetch the credits for a movie.
   * 
   * @param integer $id
   *   The movie id within tmdb.
   * 
   * @return array
   *   An array of credit objects.
   */
  protected function fetchMovieCredits($id) {
    return $this->fetch("3/movie/{$id}/credits");
  }

  /**
   * Request data from TMDB API.
   * 
   * @todo: Check response codes and add error handling.
   * 
   * @param string $endpoint
   *   The complete path of TMDB endpoint.
   * 
   * @return object
   *   The JSON response decoded to an object.
   */
  protected function fetch($endpoint) {
    $this->response = $this->client->get($endpoint, [
      'query' => [
        'api_key' => $this->config->get('tmdb_api_key'),
      ]
    ]);
    return Json::decode($this->response->getBody());
  }

}
