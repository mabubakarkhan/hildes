<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $jobsByStatus = Job::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', [
            'stats' => [
                'jobs' => Job::count(),
                'newApplications' => JobApplication::where('status', 'new')->count(),
                'users' => User::count(),
                'notifications' => DatabaseNotification::whereNull('read_at')->count(),
            ],
            'jobStatusLabels' => array_values($jobsByStatus->keys()->toArray()),
            'jobStatusData' => array_values($jobsByStatus->values()->toArray()),
            // Demo chart series for now. Replace with real metrics later.
            'demoCharts' => [
                'trafficLabels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'trafficValues' => [220, 280, 260, 340, 390, 420],
                'serviceLabels' => ['Web', 'Mobile', 'AI', 'SEO', 'Graphics'],
                'serviceValues' => [44, 22, 18, 10, 6],
                'applicationsLabels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                'applicationsValues' => [8, 13, 10, 17],
                'conversionLabels' => ['Leads', 'Interviews', 'Offers', 'Hired'],
                'conversionValues' => [100, 54, 26, 12],
            ],
        ]);
    }
}
