<?php

namespace Drupal\tmdb;

use Drupal\tmdb\Client;

class MovieList {

  /**
   * TMDB client.
   * 
   * @var \Drupal\tmdb\Client
   */
  protected $client;

  /**
   * The JSON response decoded to an object.
   * 
   * @var Object
   */
  protected $movies;

  /**
   * Constructor.
   *
   * @param $client \Drupal\tmdb\Client
   *   TMDB client.
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * Get the primary information about a list of movie.
   * 
   * @param integer $id
   *   The list id within tmdb.
   *
   * @return MovieList
   *   This object.
   */
  public function getList($id = '139830') {
    $this->movies = $this->client->fetchList($id)['items'];
    return $this;
  }

  public function getMovies() {
    $this->getList($id))
    return $this->movies;
  }

}
