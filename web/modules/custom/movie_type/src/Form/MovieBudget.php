<?php

namespace Drupal\movie_type\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a config form with its build, validation and submission methods.
 */
class MovieBudget extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'movie_budget_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'movie_budget.admin_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('movie_budget.admin_settings');
    $form['budget'] = [
      '#type' => 'number',
      '#title' => 'Enter Movie Budget',
      '#default_value' => $config->get('budget'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(&$form, FormStateInterface $form_state) {
    $this->config('movie_budget.admin_settings')
      ->set('budget', $form_state->getValue('budget'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
