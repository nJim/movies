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
   * A movie object decoded from TMDB responses.
   * 
   * @var Object
   */
  protected $movie;

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
  public function getMovieById($id) {
    $this->movie = $this->client->getMovie($id);
    return $this;
  }

  /**
   * Get the primary information about a movie.
   * 
   * @param object $movie
   *   The movie object returned from TMDB.
   *
   * @return Movie
   *   This object.
   */
  public function loadMovie($movie) {
    $this->movie = $movie;
    return $this;
  }

  public function getImdbId() {
    return $this->movie['imdb_id'];
  }

  public function getOverview() {
    return $this->movie['overview'];
  }

  // @todo.
  public function getPosterPath() {
    return $this->movie['poster_path'];
  }

  public function getReleaseDate() {
    return $this->movie['release_date'];
  }

  public function getRevenue() {
    return $this->movie['revenue'];
  }

  // @todo.
  public function getRuntime() {
    return $this->movie['runtime'];
  }

  public function getTagline() {
    return $this->movie['tagline'];
  }

  public function getTitle() {
    return $this->movie['title'];
  }

  public function getVoteAverage() {
    return $this->movie['vote_average'];
  }

}
