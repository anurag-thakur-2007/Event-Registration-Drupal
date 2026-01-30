<?php

namespace Drupal\event_registration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class EventListController extends ControllerBase {

  public function eventList() {
    $header = [
      'id' => $this->t('ID'),
      'event_name' => $this->t('Event Name'),
      'category' => $this->t('Category'),
      'event_date' => $this->t('Event Date'),
      'reg_period' => $this->t('Registration Period'),
    ];

    $rows = [];

    $query = Database::getConnection()->select('event_registration_event', 'e')
      ->fields('e', [
        'id',
        'event_name',
        'category',
        'event_date',
        'reg_start',
        'reg_end',
      ])
      ->orderBy('event_date', 'DESC');

    $result = $query->execute();

    foreach ($result as $record) {
      $rows[] = [
        'id' => $record->id,
        'event_name' => $record->event_name,
        'category' => $record->category,
        'event_date' => $record->event_date,
        'reg_period' => $record->reg_start . ' → ' . $record->reg_end,
      ];
    }

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No events found.'),
    ];
  }

}
