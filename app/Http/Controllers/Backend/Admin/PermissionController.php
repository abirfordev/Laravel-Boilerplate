<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Permission as AdminPermission;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('permission_read')) {
            $name = null;
            $permissions = AdminPermission::latest()->with('module');
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $permissions = $permissions->where('name', 'like', '%' . $name . '%');
            }
            $permissions = $permissions->paginate(15);

            $can_read = auth()->user()->can('permission_read') ? "style=cursor:pointer;" : "style=display:none;";
            $can_update = auth()->user()->can('permission_update') ? "style=cursor:pointer;" : "style=display:none;";
            $can_delete = auth()->user()->can('permission_delete') ? "style=cursor:pointer;" : "style=display:none;";

            return view('backend.admin.permission.index', compact('permissions', 'name', 'can_read', 'can_update', 'can_delete'));
        } else {
            $link = "admin.dashboard";
            return view('error.403', compact('link'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('permission_create')) {
                $modules = Module::whereStatus(1)->whereIsLabel(0)->get();
                $view = View::make('backend.admin.permission.create', compact('modules'))->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access this page');
            }
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
            if (auth()->user()->can('permission_create')) {
                $rules = [
                    'module_id' => 'required',
                    'name' => 'required',
                    'label' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray()
                    ]);
                } else {
                    $modules = $request->input('module_id');


                    DB::beginTransaction();
                    try {
                        foreach ($modules as $module) {

                            $arr = explode(', ', $module);

                            $data = [
                                'name' => $arr[1] . '_' . $request->input('name'),
                                'label' => $request->input('label'),
                                'module_id' => $arr[0],
                                'is_visibile_to_role' => $request->has('is_visibile_to_role') ? 1 : 0
                            ];
                            Permission::Create($data);
                        }

                        DB::commit();

                        return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
                    } catch (Exception $e) {
                        DB::rollback();
                        return response()->json(['type' => 'error', 'message' => "<div class='alert alert-danger'>" . $e->getMessage() . "</div>"]);
                    }
                }
            } else {
                abort(403, 'Sorry, you are not authorized to access this page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, AdminPermission $permission)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('permission_read')) {
                $view = View::make('backend.admin.permission.view', compact('permission'))->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access this page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Permission $permission)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('permission_update')) {
                $modules = Module::whereIsLabel(0)->get();
                $view = View::make('backend.admin.permission.edit', compact('permission', 'modules'))->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access this page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('permission_update')) {
                $rules = [
                    'module_id' => 'required',
                    'name' => 'required|unique:permissions,name,' . $permission->id,
                    'label' => 'required',
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

                        $permission->module_id = $request->input('module_id');
                        $permission->name = $request->input('name');
                        $permission->label = $request->input('label');
                        $permission->is_visibile_to_role = $request->has('is_visibile_to_role') ? 1 : 0;
                        $permission->status = $request->input('status');
                        $permission->save();

                        DB::commit();

                        return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                    } catch (Exception $e) {
                        DB::rollback();
                        return response()->json(['type' => 'error', 'message' => "<div class='alert alert-danger'>" . $e->getMessage() . "</div>"]);
                    }
                }
            } else {
                abort(403, 'Sorry, you are not authorized to access this page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, AdminPermission $permission)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('permission_delete')) {
                DB::beginTransaction();
                try {
                    $permission->delete();
                    DB::commit();
                    return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
                } catch (Exception $e) {
                    DB::rollback();
                    return response()->json(['type' => 'error', 'message' => "<div class='alert alert-danger'>" . $e->getMessage() . "</div>"]);
                }
            } else {
                abort(403, 'Sorry, you are not authorized to access this page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
}
