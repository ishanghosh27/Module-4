<?php

namespace Drupal\movie_type\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form handler for the Movie Award add and edit forms.
 */
class MovieAwardForm extends EntityForm {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs an MovieAwardForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entityTypeManager.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $entity = $this->entity;
    $movie_id = $this->entity->get('movie') ?? '';
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $entity->label(),
      '#description' => $this->t("Name Of The Movie Award."),
      '#required' => TRUE,
    ];
    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity->id(),
      '#machine_name' => [
        'exists' => [$this, 'exist'],
      ],
      '#disabled' => !$entity->isNew(),
    ];
    $form['year'] = [
      '#type' => 'number',
      '#title' => $this->t('Winning Year'),
      '#default_value' => $entity->get('year'),
      '#description' => $this->t('The year the movie won the award.'),
      '#required' => TRUE,
    ];
    $form['movie'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Movie'),
      '#target_type' => 'node',
      '#selection_handler' => 'default:node',
      '#selection_settings' => [
        'target_bundles' => ['movie_type'],
      ],
      '#default_value' => $this->entityTypeManager->getStorage('node')->load($movie_id) ?? '',
      '#required' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = $entity->save();
    if ($status === SAVED_NEW) {
      $this->messenger()->addMessage($this->t('The %label Movie Award has been created.', [
        '%label' => $entity->label(),
      ]));
    }
    else {
      $this->messenger()->addMessage($this->t('The %label Movie Award has been updated.', [
        '%label' => $entity->label(),
      ]));
    }
    $form_state->setRedirect('entity.award.collection');
  }

  /**
   * Helper function to check whether a Movie Award configuration entity exists.
   *
   * @param string $id
   *   The ID of the Movie Award entity.
   *
   * @return bool
   *   TRUE if the Movie Award entity exists, FALSE otherwise.
   */
  public function exist($id) {
    $entity = $this->entityTypeManager->getStorage('award')->getQuery()
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

}
