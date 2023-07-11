<?php

  namespace Drupal\config_form_one\Form;

  use Drupal\Core\Form\ConfigFormBase;
  use Drupal\Core\Form\FormStateInterface;

  /**
   * Defines a form that configures config_form_one's settings.
   */
  class ConfigOne extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
      return 'config_form_one_admin_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
      return [
        'config_form_one.admin_settings',
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
      $config = $this->config('config_form_one.admin_settings');
      $form['fullName'] = [
        '#type' => 'textfield',
        '#title' => t('Enter Full Name'),
        '#required' => TRUE,
      ];
      $form['phone'] = [
        '#type' => 'tel',
        '#title' => t('Enter Phone Number'),
        '#required' => TRUE,
      ];
      $form['email'] = [
        '#type' => 'email',
        '#title' => t('Enter Email ID'),
        '#required' => TRUE,
      ];
      $form['gender'] = [
        '#type' => 'radios',
        '#title' => t('Select Gender'),
        '#options' => [
          'Male' => t('Male'),
          'Female' => t('Female'),
          'Other' => t('Other'),
        ],
        '#required' => TRUE,
      ];
      $form['quantity_range'] = [
        '#type' => 'range',
        '#title' => 'How Much Do You Like This Module?'
      ];
      $form['message'] = [
        '#type' => 'textfield',
        '#title' => 'Your message',
        '#default_value' => $config->get('message'),
      ];
      return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
      // Validate Phone Number
      if (empty($form_state->getValue('phone'))) {
        $form_state->setErrorByName('phone', $this->t('Phone Number Cannot Be Empty'));
      }
      elseif (!preg_match('/^[6-9]\d{9}$/', ($form_state->getValue('phone')))) {
        $form_state->setErrorByName('phone', $this->t('Please Enter A Valid Indian Phone Number'));
      }
      // Validate Email ID
      $email = $form_state->getValue('email');
      if (empty($email)) {
        $form_state->setErrorByName('email', $this->t('Email ID Cannot Be Empty'));
      }
      elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_state->setErrorByName('email', $this->t('Invalid Email ID Syntax'));
      }
      elseif (!in_array(substr($email, strrpos($email, '@') + 1), ['yahoo.com', 'gmail.com', 'outlook.com'])) {
        $form_state->setErrorByName('email', $this->t('Only Public Domains (yahoo.com,gmail.com,outlook.com) Are Allowed'));
      }
      elseif (!preg_match('/\.com$/', $email)) {
        $form_state->setErrorByName('email', $this->t('Email ID Should End With ".com"'));
      }
      parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $this->config('config_form_one.admin_settings')
        ->set('fullName', $form_state->getValue('fullName'))
        ->set('phone', $form_state->getValue('phone'))
        ->set('email', $form_state->getValue('email'))
        ->set('gender', $form_state->getValue('gender'))
        ->set('quantity_range', $form_state->getValue('quantity_range'))
        ->set('message', $form_state->getValue('message'))
        // ->set('color', $form_state->getValue('color'))
        ->save();
      // $config = $this->config('config_form_one.admin_settings');
      // $config->set('form_state', $form_state->getValues());
      // $config->unset('form_build_id');
      // $config->save();
      parent::submitForm($form, $form_state);
    }

  }

?>
