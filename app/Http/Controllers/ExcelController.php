<?php

namespace App\Http\Controllers;

use App\Exports\ActivityActiveMembersExport;
use App\Exports\ActivityMembersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    //
    /**
     * Export data anggota ke dalam file Excel.
     */
    public function exportExcel($activityCode)
    {
        return Excel::download(
            new ActivityMembersExport($activityCode),
            'activity_' . $activityCode . '_members.xlsx'
        );
    }

    public function exportExcelAnggota($activityCode)
    {
        return Excel::download(
            new ActivityActiveMembersExport($activityCode),
            'anggota_' . $activityCode . '.xlsx'
        );
    }
}
