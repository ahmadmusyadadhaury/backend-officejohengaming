<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Modul IT Ticketing System
    |--------------------------------------------------------------------------
    */

    'locations' => [
        'Lantai 1',
        'Lantai 2',
        'Lantai 3',
        'Gudang',
        'MES',
        'Office',
        'Meeting Room',
        'Lainnya',
    ],

    'priorities' => [
        'low',
        'medium',
        'high',
        'urgent',
    ],

    'priority_labels' => [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent',
    ],

    'priority_colors' => [
        'low' => '#22c55e',
        'medium' => '#3b82f6',
        'high' => '#f97316',
        'urgent' => '#ef4444',
    ],

    'statuses' => [
        'open',
        'assigned',
        'in_progress',
        'waiting_user',
        'resolved',
        'closed',
        'cancelled',
        'rejected',
        'reopened',
    ],

    'status_labels' => [
        'open' => 'Open',
        'assigned' => 'Assigned',
        'in_progress' => 'In Progress',
        'waiting_user' => 'Waiting User',
        'resolved' => 'Resolved',
        'closed' => 'Closed',
        'cancelled' => 'Cancelled',
        'rejected' => 'Rejected',
        'reopened' => 'Reopened',
    ],

    'status_colors' => [
        'open' => '#94a3b8',
        'assigned' => '#3b82f6',
        'in_progress' => '#f59e0b',
        'waiting_user' => '#8b5cf6',
        'resolved' => '#22c55e',
        'closed' => '#15803d',
        'cancelled' => '#111827',
        'rejected' => '#ef4444',
        'reopened' => '#f97316',
    ],

    // Status yang tidak lagi terhitung SLA (bukan "terlambat")
    'closed_statuses' => ['resolved', 'closed', 'cancelled', 'rejected'],

    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'],

    'max_attachment_size' => 10240, // KB (10 MB)

    'attachments_disk' => 'public',

    'attachments_folder' => 'ticket-attachments',

    // Status SLA default (dalam menit) — dipakai seeder bila tabel kosong
    'default_sla' => [
        'low' => 3 * 24 * 60,
        'medium' => 1 * 24 * 60,
        'high' => 4 * 60,
        'urgent' => 2 * 60,
    ],
];
