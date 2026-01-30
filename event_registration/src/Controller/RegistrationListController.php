<?php

namespace Drupal\event_registration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class RegistrationListController extends ControllerBase {

  protected Connection $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  public function list(Request $request) {
    $event_date = $request->query->get('event_date');
    $event_id = $request->query->get('event_id');

    /* ---------------------------
     * Fetch distinct event dates
     * --------------------------- */
    $dates = $this->database->select('event_registration_event', 'e')
      ->fields('e', ['event_date'])
      ->distinct()
      ->execute()
      ->fetchCol();

    /* ---------------------------
     * Fetch events for selected date
     * --------------------------- */
    $events = [];
    if ($event_date) {
      $event_query = $this->database->select('event_registration_event', 'e')
        ->fields('e', ['id', 'event_name'])
        ->condition('event_date', $event_date);

      foreach ($event_query->execute() as $event) {
        $events[$event->id] = $event->event_name;
      }
    }

    /* ---------------------------
     * Fetch registrations
     * --------------------------- */
    $query = $this->database->select('event_registration_signup', 's');
    $query->join('event_registration_event', 'e', 'e.id = s.event_id');

    $query->fields('s', [
      'full_name',
      'email',
      'college',
      'department',
      'created',
    ]);

    $query->fields('e', [
      'event_name',
      'event_date',
    ]);

    if ($event_date) {
      $query->condition('e.event_date', $event_date);
    }

    if ($event_id) {
      $query->condition('e.id', $event_id);
    }

    $rows = [];
    foreach ($query->execute() as $row) {
      $rows[] = [
        $row->full_name,
        $row->email,
        $row->event_name,
        $row->event_date,
        $row->college,
        $row->department,
        date('Y-m-d H:i', $row->created),
      ];
    }

    $count = count($rows);

    return [
      '#type' => 'container',
      'filter' => [
        '#markup' => $this->filterForm($dates, $events, $event_date, $event_id),
      ],
      'table' => [
        '#theme' => 'table',
        '#header' => [
          'Name',
          'Email',
          'Event',
          'Event Date',
          'College',
          'Department',
          'Submitted',
        ],
        '#rows' => $rows,
        '#empty' => $this->t('No registrations found.'),
        '#caption' => $this->t('Total participants: @count', ['@count' => $count]),
      ],
      'export' => [
        '#markup' => $this->csvLink($event_date, $event_id),
      ],
    ];
  }

  private function filterForm(array $dates, array $events, $selected_date, $selected_event) {
  $date_options = '<option value="">All Dates</option>';
  foreach ($dates as $date) {
    $selected = ($date == $selected_date) ? 'selected' : '';
    $date_options .= "<option value=\"$date\" $selected>$date</option>";
  }

  $event_options = '<option value="">All Events</option>';
  foreach ($events as $id => $name) {
    $selected = ($id == $selected_event) ? 'selected' : '';
    $event_options .= "<option value=\"$id\" $selected>$name</option>";
  }

  return "
    <form method='get' style='margin-bottom:20px; display:flex; gap:16px; align-items:end;'>
      <div>
        <label><strong>Event Date</strong></label><br>
        <select name='event_date' onchange='this.form.submit()'>
          $date_options
        </select>
      </div>

      <div>
        <label><strong>Event Name</strong></label><br>
        <select name='event_id' onchange='this.form.submit()'>
          $event_options
        </select>
      </div>
    </form>
  ";
}


  private function csvLink($event_date, $event_id) {
    $url = Url::fromRoute(
      'event_registration.registration_export',
      [],
      [
        'query' => [
          'event_date' => $event_date,
          'event_id' => $event_id,
        ],
      ]
    )->toString();

    return "<p><a class='button button--primary' href='{$url}'>Export CSV</a></p>";

  }

}
