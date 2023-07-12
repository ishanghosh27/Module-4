<?php

  namespace Drupal\ajax_form_one\Form;

  use Drupal\Core\Form\ConfigFormBase;
  use Drupal\Core\Form\FormStateInterface;
  use Drupal\Core\Ajax\AjaxResponse;
  use Drupal\Core\Ajax\HtmlCommand;
  use Drupal\Core\Ajax\CssCommand;
  /**
   * Defines a form that configures ajax_form_one's settings.
   */
  class AjaxOne extends ConfigFormBase {

    protected $response;

    public function __construct() {
      $this->response = new AjaxResponse();
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
      return 'ajax_form_one_admin_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
      return [
        'ajax_form_one.admin_settings',
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
      $config = $this->config('ajax_form_one.admin_settings');
      $form['fullName'] = [
        '#type' => 'textfield',
        '#title' => t('Full Name'),
        '#suffix' => '<div id="full-name-error"><strong></strong></div>',
        '#attributes' => [
          'placeholder' => t('Enter Full Name'),
        ],
      ];
      $form['phone'] = [
        '#type' => 'tel',
        '#title' => t('Phone Number'),
        '#suffix' => '<div id="phone-error"><strong></strong></div>',
        '#attributes' => [
          'placeholder' => t('Enter Phone Number'),
        ],
      ];
      $form['email'] = [
        '#type' => 'email',
        '#title' => t('Email ID'),
        '#suffix' => '<div id="email-error"><strong></strong></div>',
        '#attributes' => [
          'placeholder' => t('Enter Email ID'),
        ],
      ];
      $form['gender'] = [
        '#type' => 'radios',
        '#title' => t('Gender'),
        '#suffix' => '<div id="gender-error"><strong></strong></div>',
        '#attributes' => [
          'placeholder' => t('Select Gender'),
        ],
        '#options' => [
          'Male' => t('Male'),
          'Female' => t('Female'),
          'Other' => t('Other'),
        ],
      ];
      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
        '#button_type' => 'primary',
        '#ajax' => [
          'callback' => '::validateAjaxForm',
          'progress' => [
            'type' => 'throbber',
            'message' => $this->t('Validating Form'),
          ],
        ],
      ];
      return $form;
    }

    public function validateAjaxForm(array &$form, FormStateInterface $form_state) {
      $this->validateName($form_state);
      $this->validatePhone($form_state);
      $this->validateEmail($form_state);
      $this->validateGender($form_state);
      if(!$form_state->hasAnyErrors()) {
        $this->submitAjaxForm($form, $form_state);
      }
      return $this->response;
    }

    public function validateName(FormStateInterface $form_state) {
      $this->response->addCommand(new HtmlCommand('#full-name-error strong', ''));
      $name = $form_state->getValue('fullName');
      if (empty($name)) {
        $this->response->addCommand(new HtmlCommand('#full-name-error strong', 'Full Name Cannot Be Empty'));
        $this->response->addCommand(new CssCommand('#full-name-error', ['color' => '#DC3545']));
      }
      elseif (!preg_match('/^[a-zA-Z]/', $name)) {
        $this->response->addCommand(new HtmlCommand('#full-name-error strong', 'Full Name Can Only Containt Alphabets'));
        $this->response->addCommand(new CssCommand('#full-name-error', ['color' => '#DC3545']));
      }
    }

    public function validatePhone(FormStateInterface $form_state) {
      $this->response->addCommand(new HtmlCommand('#phone-error strong', ''));
      $phone = $form_state->getValue('phone');
      if (empty($phone)) {
        $this->response->addCommand(new HtmlCommand('#phone-error strong', 'Phone Number Cannot Be Empty'));
        $this->response->addCommand(new CssCommand('#phone-error', ['color' => '#DC3545']));
      }
      elseif (!preg_match('/^[6-9]\d{9}$/', $phone)) {
        $this->response->addCommand(new HtmlCommand('#phone-error strong', 'Please Enter A Valid Indian Phone Number'));
        $this->response->addCommand(new CssCommand('#phone-error', ['color' => '#DC3545']));
      }
    }

    public function validateEmail(FormStateInterface $form_state) {
      $this->response->addCommand(new HtmlCommand('#email-error strong', ''));
      $email = $form_state->getValue('email');
      if (empty($email)) {
        $this->response->addCommand(new HtmlCommand('#email-error strong', 'Email ID Cannot Be Empty'));
        $this->response->addCommand(new CssCommand('#email-error', ['color' => '#DC3545']));
      }
      elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->response->addCommand(new HtmlCommand('#email-error strong', 'Invalid Email ID Syntax'));
        $this->response->addCommand(new CssCommand('#email-error', ['color' => '#DC3545']));
      }
      elseif (!in_array(substr($email, strrpos($email, '@') + 1), ['yahoo.com', 'gmail.com', 'outlook.com', 'innoraft.com'])) {
        $this->response->addCommand(new HtmlCommand('#email-error strong', 'Only Public Domains (yahoo.com, gmail.com, outlook.com, innoraft.com) Are Allowed'));
        $this->response->addCommand(new CssCommand('#email-error', ['color' => '#DC3545']));
      }
    }

    public function validateGender(FormStateInterface $form_state) {
      $this->response->addCommand(new HtmlCommand('#gender-error strong', ''));
      $gender = $form_state->getValue('gender');
      if (empty($gender)) {
        $this->response->addCommand(new HtmlCommand('#gender-error strong', 'Gender Cannot Be Empty'));
        $this->response->addCommand(new CssCommand('#gender-error', ['color' => '#DC3545']));
      }
    }

    public function submitAjaxForm(array &$form, FormStateInterface $form_state) {
      $this->config('ajax_form_one.admin_settings')
        ->set('fullName', $form_state->getValue('fullName'))
        ->set('phone', $form_state->getValue('phone'))
        ->set('email', $form_state->getValue('email'))
        ->set('gender', $form_state->getValue('gender'))
        ->save();
    }

  }

?>
