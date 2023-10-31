<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->can('activity_log_read')) {
            $logs = Activity::latest()->paginate(10);
            return view('backend.admin.activity-log.index', compact('logs'));
        } else {
            $link = "admin.dashboard";
            return view('error.403', compact('link'));
        }
    }
}
