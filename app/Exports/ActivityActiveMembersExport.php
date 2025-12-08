<?php

namespace App\Exports;

use App\Models\ActivityStructure;
use App\Models\StudentActivity;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivityActiveMembersExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $activityCode;
    private $rowNumber = 0; // To keep track of the "No" column

    public function __construct($activityCode)
    {
        $this->activityCode = $activityCode;
    }

    public function query()
    {
        // 1. Select members where the related activity matches the code
        // 2. Eager load ('with') the student to avoid N+1 query performance issues

        $activity = StudentActivity::where('activity_code', $this->activityCode)->firstOrFail();

        return ActivityStructure::where('student_activity_id', $activity->student_activity_id)
            ->with('student');
    }

    /**
     * Map each row. This is where you grab data from the relation.
     * @var ActivityStructure $member
     */
    public function map($member): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,                     // No
            $member->student->full_name,          // Student Full Name
            $member->student->student_number,     // Student NRP
            $member->role->role_code,             // Role
            $member->subRole->sub_role_code,      // Sub Role
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Full Name',
            'NRP',
            'Role',
            'Sub Role',
        ];
    }
}
