<?php

namespace App\Http\Controllers;

use App\Exports\MomExport;
use App\Models\Mom;
use Maatwebsite\Excel\Facades\Excel;

class MomExportController extends Controller
{
    public function export(Mom $mom)
    {
        $mom->load(['meeting.room', 'meeting.requester', 'meeting.participants']);

        $title = 'MOM_'.str_replace(' ', '_', $mom->meeting->title).'_'.$mom->meeting->meeting_date->format('d-m-Y');

        return Excel::download(new MomExport($mom), $title.'.xlsx');
    }
}
