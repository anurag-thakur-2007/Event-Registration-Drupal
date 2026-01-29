<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EventRegisterForm extends FormBase {

  protected Connection $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  public function getFormId() {
    return 'event_registration_user_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    // ✅ Rebuild selected values during normal form build
    $category = $form_state->getValue('category');
    $event_date = $form_state->getValue('event_date');

    $date_options = ['' => $this->t('- Select -')];
    $event_options = ['' => $this->t('- Select -')];

    if ($category) {
      $query = $this->database->select('event_registration_event', 'e')
        ->fields('e', ['event_date'])
        ->condition('category', $category)
        ->distinct();

      foreach ($query->execute() as $row) {
        $date_options[$row->event_date] = $row->event_date;
      }
    }

    if ($category && $event_date) {
      $query = $this->database->select('event_registration_event', 'e')
        ->fields('e', ['id', 'event_name'])
        ->condition('category', $category)
        ->condition('event_date', $event_date);

      foreach ($query->execute() as $row) {
        $event_options[$row->id] = $row->event_name;
      }
    }

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email Address'),
      '#required' => TRUE,
    ];

    $form['college'] = [
      '#type' => 'textfield',
      '#title' => $this->t('College Name'),
      '#required' => TRUE,
    ];

    $form['department'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Department'),
      '#required' => TRUE,
    ];

    $form['category'] = [
      '#type' => 'select',
      '#title' => $this->t('Event Category'),
      '#options' => $this->getCategories(),
      '#empty_option' => $this->t('- Select -'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::updateDates',
        'wrapper' => 'event-date-wrapper',
      ],
      '#limit_validation_errors' => [],
    ];

    $form['event_date'] = [
      '#type' => 'select',
      '#title' => $this->t('Event Date'),
      '#prefix' => '<div id="event-date-wrapper">',
      '#suffix' => '</div>',
      '#options' => $date_options,
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::updateEvents',
        'wrapper' => 'event-name-wrapper',
      ],
      '#limit_validation_errors' => [],
      '#validated' => TRUE,
    ];

    $form['event_id'] = [
      '#type' => 'select',
      '#title' => $this->t('Event Name'),
      '#prefix' => '<div id="event-name-wrapper">',
      '#suffix' => '</div>',
      '#options' => $event_options,
      '#required' => TRUE,
      '#validated' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Register'),
    ];

    return $form;
  }

  private function getCategories() {
    $options = [];

    $query = $this->database->select('event_registration_event', 'e')
      ->fields('e', ['category'])
      ->distinct();

    foreach ($query->execute() as $row) {
      $options[$row->category] = $row->category;
    }

    return $options;
  }

  public function updateDates(array &$form, FormStateInterface $form_state) {
    $category = $form_state->getValue('category');
    $options = ['' => $this->t('- Select -')];

    if ($category) {
      $query = $this->database->select('event_registration_event', 'e')
        ->fields('e', ['event_date'])
        ->condition('category', $category)
        ->distinct();

      foreach ($query->execute() as $row) {
        $options[$row->event_date] = $row->event_date;
      }
    }

    $form['event_date']['#options'] = $options;
    $form_state->setRebuild(TRUE);

    return $form['event_date'];
  }

  public function updateEvents(array &$form, FormStateInterface $form_state) {
    $category = $form_state->getValue('category');
    $date = $form_state->getValue('event_date');
    $options = ['' => $this->t('- Select -')];

    if ($category && $date) {
      $query = $this->database->select('event_registration_event', 'e')
        ->fields('e', ['id', 'event_name'])
        ->condition('category', $category)
        ->condition('event_date', $date);

      foreach ($query->execute() as $row) {
        $options[$row->id] = $row->event_name;
      }
    }

    $form['event_id']['#options'] = $options;
    $form_state->setRebuild(TRUE);

    return $form['event_id'];
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (!filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
    }

    $pattern = '/^[a-zA-Z0-9\s]+$/';
    foreach (['full_name', 'college', 'department'] as $field) {
      if (!preg_match($pattern, $form_state->getValue($field))) {
        $form_state->setErrorByName(
          $field,
          $this->t('Special characters are not allowed in this field.')
        );
      }
    }

    $exists = $this->database->select('event_registration_signup', 's')
      ->fields('s', ['id'])
      ->condition('email', $form_state->getValue('email'))
      ->condition('event_id', $form_state->getValue('event_id'))
      ->execute()
      ->fetchField();

    if ($exists) {
      $form_state->setErrorByName('email', $this->t('You have already registered for this event.'));
    }

    $event = $this->database->select('event_registration_event', 'e')
      ->fields('e', ['reg_start', 'reg_end'])
      ->condition('id', $form_state->getValue('event_id'))
      ->execute()
      ->fetchAssoc();

    if ($event) {
      $today = date('Y-m-d');
      if ($today < $event['reg_start'] || $today > $event['reg_end']) {
        $form_state->setErrorByName(
          'event_id',
          $this->t('Registration is closed for this event.')
        );
      }
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

  // 1️⃣ Save registration to DB
  $this->database->insert('event_registration_signup')
    ->fields([
      'event_id' => $form_state->getValue('event_id'),
      'full_name' => $form_state->getValue('full_name'),
      'email' => $form_state->getValue('email'),
      'college' => $form_state->getValue('college'),
      'department' => $form_state->getValue('department'),
      'created' => time(),
    ])
    ->execute();

  // 2️⃣ Load config
  $config = $this->config('event_registration.settings');

  // 3️⃣ Prepare mail manager
  $mailManager = \Drupal::service('plugin.manager.mail');
  $langcode = \Drupal::languageManager()->getDefaultLanguage()->getId();

  // Fetch event details
  $event = $this->database->select('event_registration_event', 'e')
    ->fields('e', ['event_name', 'event_date', 'category'])
    ->condition('id', $form_state->getValue('event_id'))
    ->execute()
    ->fetchAssoc();

  // 4️⃣ USER confirmation email
  $mailManager->mail(
    'event_registration',
    'user_confirmation',
    $form_state->getValue('email'),
    $langcode,
    [
      'subject' => 'Event Registration Confirmation',
      'message' =>
        "Hello {$form_state->getValue('full_name')},\n\n" .
        "You have successfully registered for the event.\n\n" .
        "Event Name: {$event['event_name']}\n" .
        "Category: {$event['category']}\n" .
        "Event Date: {$event['event_date']}\n\n" .
        "Thank you!"
    ]
  );

  // 5️⃣ ADMIN notification email (only if enabled)
  if ($config->get('enable_admin_notification')) {
    $mailManager->mail(
      'event_registration',
      'admin_notification',
      $config->get('admin_email'),
      $langcode,
      [
        'subject' => 'New Event Registration',
        'message' =>
          "New registration received:\n\n" .
          "Name: {$form_state->getValue('full_name')}\n" .
          "Email: {$form_state->getValue('email')}\n" .
          "Event: {$event['event_name']}\n" .
          "Date: {$event['event_date']}\n"
      ]
    );
  }

  // 6️⃣ Success message
  $this->messenger()->addStatus($this->t('Registration successful. Confirmation email sent.'));
}


}
