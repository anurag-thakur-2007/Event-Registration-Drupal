<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class EventAddForm extends FormBase {

  public function getFormId() {
    return 'event_registration_add_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['event_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Event Name'),
      '#required' => TRUE,
    ];

    $form['category'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Category'),
      '#required' => TRUE,
    ];

    $form['event_date'] = [
      '#type' => 'date',
      '#title' => $this->t('Event Date'),
      '#required' => TRUE,
    ];

    $form['reg_start'] = [
      '#type' => 'date',
      '#title' => $this->t('Registration Start Date'),
      '#required' => TRUE,
    ];

    $form['reg_end'] = [
      '#type' => 'date',
      '#title' => $this->t('Registration End Date'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save Event'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    Database::getConnection()->insert('event_registration_event')
      ->fields([
        'event_name' => $form_state->getValue('event_name'),
        'category' => $form_state->getValue('category'),
        'event_date' => $form_state->getValue('event_date'),
        'reg_start' => $form_state->getValue('reg_start'),
        'reg_end' => $form_state->getValue('reg_end'),
        'created' => time(),
      ])
      ->execute();

    $this->messenger()->addStatus($this->t('Event saved successfully.'));
  }
}
