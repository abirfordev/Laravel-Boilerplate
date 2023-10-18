<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::all();
        return view('backend.admin.setting.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $view = View::make('backend.admin.setting.create')->render();
            return response()->json(['html' => $view]);
            // $roles = Role::all();
            // return view('backend.admin.admin.create', compact('roles'));
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                'name' => 'required|unique:settings,name',
                'label' => 'required|unique:settings,label',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {

                DB::beginTransaction();
                try {

                    $setting = new Setting();
                    $setting->name = $request->input('name');
                    $setting->label = $request->input('label');
                    $setting->value = $request->input('value');
                    $setting->instruction = $request->input('instruction');
                    $setting->save();

                    DB::commit();

                    return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
                } catch (Exception $e) {
                    DB::rollback();
                    return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        // dd($request->input('settings'));
        // $requests = $request->input();
        // array_shift($requests);
        // array_pop($requests);

        // dd($requests);

        if ($request->ajax()) {

            DB::beginTransaction();
            try {

                foreach ($request->input('settings') as $key => $value) {
                    //dd($key, $value);
                    Setting::firstWhere('name', $key)->update([
                        'value' => $value
                    ]);
                }

                DB::commit();

                return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
