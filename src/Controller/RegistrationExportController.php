<?php

namespace Drupal\event_registration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RegistrationExportController extends ControllerBase {

  protected Connection $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  public function export(Request $request) {
    $event_date = $request->query->get('event_date');
    $event_id   = $request->query->get('event_id');

    /* ---------------------------
     * Build query
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

    $results = $query->execute();

    /* ---------------------------
     * Build CSV
     * --------------------------- */
    $rows = [];
    $rows[] = [
      'Name',
      'Email',
      'Event',
      'Event Date',
      'College',
      'Department',
      'Registered At',
    ];

    foreach ($results as $row) {
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

    $output = '';
    foreach ($rows as $row) {
      $output .= '"' . implode('","', $row) . '"' . "\n";
    }

    $filename = 'event_registrations_' . date('Ymd_His') . '.csv';

    return new Response(
      $output,
      200,
      [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
      ]
    );
  }
}
