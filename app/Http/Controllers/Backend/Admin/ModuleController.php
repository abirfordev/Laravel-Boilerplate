<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('module_read')) {
            $name = null;
            $modules = Module::latest();
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $modules = $modules->where('name', 'like', '%' . $name . '%');
            }
            $modules = $modules->paginate(15);

            return view('backend.admin.module.index', compact('modules', 'name'));
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
            if (auth()->user()->can('module_create')) {
                $modules = Module::whereStatus(1)->get();
                $view = View::make('backend.admin.module.create', compact('modules'))->render();
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
            if (auth()->user()->can('module_create')) {
                $rules = [
                    'name' => 'required|unique:modules,name',
                    'permission_slug' =>
                    'required|unique:modules,permission_slug',
                    'parent_module_id' => 'required_if:is_children,on',
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

                        $module = new Module();
                        $module->name = $request->input('name');
                        $module->url = $request->input('url');
                        $module->permission_slug = $request->input('permission_slug');
                        $module->is_children = $request->has('is_children') ? 1 : 0;;
                        $module->is_label = $request->has('is_label') ? 1 : 0;
                        $module->is_visibile_to_role = $request->has('is_visibile_to_role') ? 1 : 0;
                        $module->parent_module_id =
                            $request->has('is_children') ? $request->input('parent_module_id') : null;

                        $module->save();

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
    public function show(Request $request, Module $module)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('module_read')) {
                $view = View::make('backend.admin.module.view', compact('module'))->render();
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
    public function edit(Request $request, Module $module)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('module_update')) {
                $modules = Module::all();
                $view = View::make('backend.admin.module.edit', compact('module', 'modules'))->render();
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
    public function update(Request $request, Module $module)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('module_update')) {
                $rules = [
                    'name' => 'required|unique:modules,name,' . $module->id,
                    'permission_slug' =>
                    'required|unique:modules,permission_slug,' . $module->id,
                    'parent_module_id' => 'required_if:is_children,on',
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

                        $module->name = $request->input('name');
                        $module->url = $request->input('url');
                        $module->permission_slug = $request->input('permission_slug');
                        $module->is_children = $request->has('is_children') ? 1 : 0;;
                        $module->is_label = $request->has('is_label') ? 1 : 0;
                        $module->is_visibile_to_role = $request->has('is_visibile_to_role') ? 1 : 0;
                        $module->parent_module_id =
                            $request->has('is_children') ? $request->input('parent_module_id') : null;

                        $module->status = $request->input('status');
                        $module->save();

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
    public function destroy(Request $request, Module $module)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('module_delete')) {
                DB::beginTransaction();
                try {
                    $module->delete();
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
        if (auth()->user()->can('module_trash')) {
            $name = null;
            $modules = Module::latest('deleted_at')->onlyTrashed();
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $modules = $modules->where('name', 'like', '%' . $name . '%');
            }
            $modules = $modules->paginate(15);

            return view('backend.admin.module.trash', compact('modules', 'name'));
        } else {
            $link = "admin.dashboard";
            return view('error.403', compact('link'));
        }
    }

    public function restore(Request $request, $id)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('module_trash')) {
                $module = Module::withTrashed()->findOrFail($id);

                DB::beginTransaction();
                try {

                    if (!empty($module)) {
                        $module->restore();
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
            if (auth()->user()->can('module_trash')) {
                DB::beginTransaction();
                try {

                    $ids = explode(",", $ids);

                    Module::withTrashed()->whereIn('id', $ids)->restore();

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
            if (auth()->user()->can('module_trash')) {
                $module = Module::withTrashed()->findOrFail($id);

                DB::beginTransaction();
                try {

                    if (!empty($module)) {
                        $module->forceDelete();
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
            if (auth()->user()->can('module_trash')) {
                DB::beginTransaction();
                try {

                    $ids = explode(",", $ids);

                    Module::withTrashed()->whereIn('id', $ids)->forceDelete();

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
