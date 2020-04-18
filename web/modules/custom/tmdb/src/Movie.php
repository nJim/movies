<?php

namespace Drupal\tmdb;

use Drupal\tmdb\Client;

class Movie {

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
  protected $response;

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
   * Get the primary information about a movie.
   * 
   * @param integer $id
   *   The movie id within tmdb.
   *
   * @return Movie
   *   This object.
   */
  public function setMovieId($id = '9607') {
    $this->response = $this->client->getMovie($id);
    return $this;
  }

  public function getImdbId() {
    return $this->response['imdb_id'];
  }

  public function getOverview() {
    return $this->response['overview'];
  }

  public function getPosterPath() {
    return $this->response['poster_path'];
  }

  public function getReleaseDate() {
    return $this->response['release_date'];
  }

  public function getRevenue() {
    return $this->response['revenue'];
  }

  public function getRuntime() {
    return $this->response['runtime'];
  }

  public function getTagline() {
    return $this->response['tagline'];
  }

  public function getTitle() {
    return $this->response['title'];
  }

  public function getAverageVote() {
    return $this->response['vote_average'];
  }

}
