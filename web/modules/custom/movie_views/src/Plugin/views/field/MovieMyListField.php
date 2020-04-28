<?php
 
/**
 * @file
 * Definition of Drupal\movie_views\Plugin\views\field\MovieMyListField
 */
 
namespace Drupal\movie_views\Plugin\views\field;

use Drupal\Core\Database\Database;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\views\Views;
 
/**
 * Returns an icon to view if a movie is on the the current user's list.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("movie_my_list_field")
 */
class MovieMyListField extends FieldPluginBase {

  /**
   * The current user object.
   * 
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * @{inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = \Drupal::currentUser();
  }
 
  /**
   * @{inheritdoc}
   */
  public function query() {
    // Create a subquery to get a list of all movies on the user's my-list.
    // SELECT field_my_list_target_id, 1 as on_list 
    // FROM user__field_my_list 
    // WHERE entity_id = 1
    $subquery = Database::getConnection()->select('user__field_my_list', 'u');
    $subquery->addExpression("u.field_my_list_target_id", 'movie_id');
    $subquery->addExpression("1", 'on_list');
    $subquery->where(
      "(entity_id = :user_id)",
      [':user_id' => $this->currentUser->id()]
    );

    // Join movies on the subquery to track which ones are on the user's list.
    // The 'table formula' property is used to join on a evaluated expression.
    $configuration = [
      'type' => 'LEFT',
      'table formula' => $subquery,
      'field' => 'movie_id',
      'left_table' => 'node_field_data',
      'left_field' => 'nid',
      'operator' => '=',
    ];
    $join = Views::pluginManager('join')->createInstance('standard', $configuration);
    $this->query->addRelationship('user_data', $join, 'node_field_data');

    // The the 'on_list' field to the views result row object.
    $this->query->addField('user_data', 'on_list', 'on_list');
  }
 
  /**
   * Renders the field.
   *
   * @param \Drupal\views\ResultRow $values
   *   The values retrieved from a single row of a view's query result.
   *
   * @return string|\Drupal\Component\Render\MarkupInterface
   *   The rendered output. If the output is safe it will be wrapped in an
   *   object that implements MarkupInterface. If it is empty or unsafe it
   *   will be a string.
   */
  public function render(ResultRow $values) {
    // Example of returning a custom template in a view.
    return [
      '#theme' => 'button__mylisticon',
      '#isAuthenticated' => $this->currentUser->isAuthenticated(),
      '#isOnMyList' => $values->on_list,
    ];
  }

}