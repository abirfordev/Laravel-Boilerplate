<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Role as AdminRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('role_read')) {
            $name = null;
            $roles = AdminRole::latest();
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $roles = $roles->where('name', 'like', '%' . $name . '%');
            }

            $roles = $roles->paginate(15);


            $can_read = auth()->user()->can('role_read') ? "" : "style=display:none";
            $can_update = auth()->user()->can('role_update') ? "" :
                "style=display:none";
            $can_delete = auth()->user()->can('role_delete') ? "" :
                "style=display:none";

            return view('backend.admin.role.index', compact('roles', 'name', 'can_read', 'can_update', 'can_delete'));
        } else {
            $link = "admin.dashboard";
            return view('error.403', compact('link'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('role_create')) {
            $modules = Module::whereIsLabel(0)->whereIsVisibileToRole(1)->whereStatus(1)->get();
            return view('backend.admin.role.create', compact('modules'));
        } else {
            $link = "admin.dashboard";
            return view('error.403', compact('link'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('role_create')) {
                $rules = [
                    'name' => 'required|unique:roles,name',
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
                        $role = Role::create(['name' => $request->input('name')]);
                        $permissions = array_map('intval', explode(",", $request->input('permissions')));
                        $role->syncPermissions($permissions);

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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if (auth()->user()->can('role_update')) {
            $modules = Module::whereIsLabel(0)->whereIsVisibileToRole(1)->get();
            return view('backend.admin.role.edit', compact('role', 'modules'));
        } else {
            $link = "admin.dashboard";
            return view('error.403', compact('link'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('role_update')) {
                $rules = [
                    'name' => 'required|unique:roles,name,' . $role->id,
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
                        $role->name = $request->input('name');
                        $role->status = $request->input('status');
                        $role->save();

                        $permissions = $request->input('permissions');

                        if (isset($permissions)) {
                            $permissions = array_map('intval', explode(",", $permissions));
                            $role->syncPermissions($permissions);  //If one or more role is selected associate user to roles
                        } else {
                            //If no role is selected remove exisiting permissions associated to a role
                            $all_permissions = $role->getAllPermissions();

                            foreach ($all_permissions as $permission) {
                                $role->revokePermissionTo($permission); //Remove all permissions associated with role
                            }
                        }

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
    public function destroy(Request $request, AdminRole $role)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('role_delete')) {
                DB::beginTransaction();
                try {
                    $role->delete();
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

    public function trashList(Request $request)
    {
        if (auth()->user()->can('role_trash')) {
            $name = null;
            $roles = AdminRole::latest('deleted_at')->onlyTrashed();
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $roles = $roles->where('name', 'like', '%' . $name . '%');
            }
            $roles = $roles->paginate(15);

            return view('backend.admin.role.trash', compact('roles', 'name'));
        } else {
            $link = "admin.dashboard";
            return view('error.403', compact('link'));
        }
    }

    public function restore(Request $request, $id)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('role_trash')) {
                $role = AdminRole::withTrashed()->findOrFail($id);

                DB::beginTransaction();
                try {

                    if (!empty($role)) {
                        $role->restore();
                    }

                    DB::commit();

                    return response()->json(['type' => 'success', 'message' => "Successfully Restored"]);
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

    public function restoreSelected(Request $request, $ids)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('role_trash')) {
                DB::beginTransaction();
                try {

                    $ids = explode(",", $ids);

                    AdminRole::withTrashed()->whereIn('id', $ids)->restore();

                    DB::commit();

                    return response()->json(['type' => 'success', 'message' => "Successfully Restored"]);
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

    public function permanentDelete(Request $request, $id)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('role_trash')) {
                $role = AdminRole::withTrashed()->findOrFail($id);

                DB::beginTransaction();
                try {

                    if (!empty($role)) {
                        $role->forceDelete();
                    }
                    DB::commit();
                    return response()->json(['type' => 'success', 'message' => "Successfully Removed"]);
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

    public function permanentDeleteSelected(Request $request, $ids)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('role_trash')) {
                DB::beginTransaction();
                try {

                    $ids = explode(",", $ids);

                    AdminRole::withTrashed()->whereIn('id', $ids)->forceDelete();

                    DB::commit();

                    return response()->json(['type' => 'success', 'message' => "Successfully Removed"]);
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
