<?php

namespace Drupal\dbt_two\Form;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This class creates, validates, and displays the details of a taxonomy term.
 */
class TaxoDashboard extends FormBase {

  /**
   * Initializes the \Drupal\Core\Ajax\AjaxResponse instance.
   *
   * @var \Drupal\Core\Ajax\AjaxResponse
   */
  protected $response;

  /**
   * Stores the database connection.
   *
   * @var object
   */
  protected $connection;

  /**
   * Storing the AjaxResponse instance to the class variable.
   *
   * This method initializes the database connection.
   *
   * * @param \Drupal\Core\Database\Connection $connection
   *   Stores the object of the Connection class - database connection.
   */
  public function __construct(Connection $connection) {
    $this->response = new AjaxResponse();
    $this->connection = $connection;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('database'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'taxo_db';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['taxo'] = [
      '#type' => 'textfield',
      '#title' => 'Enter Taxonomy Term',
      '#suffix' => '<div id="taxo-error"><strong></strong></div>',
      '#attributes' => [
        'placeholder' => 'Enter Taxonomy Term Name',
      ],
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#suffix' => '<div id="results"><strong></strong></div>',
      '#button_type' => 'primary',
      '#ajax' => [
        'callback' => '::submitAjaxForm',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Validating Taxonomy'),
        ],
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * This method submits the input data & fetches the Taxonomy Results.
   *
   * @param array $form
   *   Stores the data in the form fields.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Stores the object of FormStateInterface.
   */
  public function submitAjaxForm(array &$form, FormStateInterface $form_state) {
    $taxo = $form_state->getValue('taxo');
    $query = $this->connection->select('taxonomy_term_field_data', 't');
    $query->fields('t', ['name', 'tid'])
      ->condition('t.name', $taxo, '=')
      ->join('taxonomy_term_data', 'f', 't.tid = f.tid');
    $query->fields('f', ['uuid']);
    $taxo_nodes = $this->connection->select('taxonomy_term_field_data', 't');
    $taxo_nodes->fields('t', ['name', 'tid'])
      ->condition('t.name', $taxo, '=')
      ->join('taxonomy_index', 'f', 't.tid = f.tid');
    $taxo_nodes->fields('f', [' nid']);
    $taxo_nodes->join('node_field_data', 'n', 'f.nid = n.nid');
    $taxo_nodes->fields('n', ['title']);
    $taxo_name = $query->execute()->fetchField();
    $taxo_uuid = $query->execute()->fetchField(2);
    $taxo_node_result = $taxo_nodes->execute()->fetchAll(\PDO::FETCH_ASSOC);
    $nodeTitles = [];
    foreach ($taxo_node_result as $nodeTitle) {
      $nodeTitles[] = $nodeTitle['title'];
    }
    $nodeUrls = [];
    foreach ($taxo_node_result as $result) {
      $nid = $result['nid'];
      $url = Url::fromRoute('entity.node.canonical', ['node' => $nid]);
      $nodeUrls[] = $url->toString();
    }
    $encoded_data = Json::encode([
      'taxoName' => $taxo_name,
      'taxoUuid' => $taxo_uuid,
      'nodeTitles' => $nodeTitles,
      'nodeUrls' => $nodeUrls,
    ]);
    $decoded_data = Json::decode($encoded_data);
    $titles = implode(', ', $decoded_data['nodeTitles']);
    $urls = implode(', ', $decoded_data['nodeUrls']);
    if ($taxo_name) {
      $this->response->addCommand(new HtmlCommand('#results strong', 'Taxonomy Name - ' . $decoded_data['taxoName'] . '. Taxonomy UUID - ' . $decoded_data['taxoUuid'] . '. Node Titles Using Taxonomy - ' . $titles . '. Node Path - ' . $urls . ''));
    }
    return $this->response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}
