<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $name = null;
        $email = null;
        //$admins = DB::table('activity_log')->select('causer')->latest()->paginate(10);
        $logs = Activity::latest()->paginate(10);
        //$admins = Activity::all();


        return view('backend.admin.activity-log.index', compact('logs'));
    }
}
