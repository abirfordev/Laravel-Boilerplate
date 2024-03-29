<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('admin_read')) {
            $name = null;
            $email = null;
            $admins = Admin::latest();
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $admins = $admins->where('name', 'like', '%' . $name . '%');
            }
            if ($request->has('email') && !empty($request->input('email'))) {
                $email = $request->email;
                $admins = $admins->where('email', 'like', '%' . $email . '%');
            }
            $admins = $admins->paginate(15);

            $can_read = auth()->user()->can('admin_read') ? "style=cursor:pointer;" : "style=display:none;";
            $can_update = auth()->user()->can('admin_update') ? "style=cursor:pointer;" : "style=display:none;";
            $can_delete = auth()->user()->can('admin_delete') ? "style=cursor:pointer;" : "style=display:none;";

            return view('backend.admin.admin.index', compact('admins', 'name', 'email', 'can_read', 'can_update', 'can_delete'));
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
            if (auth()->user()->can('admin_create')) {
                $roles = Role::whereStatus(1)->get();
                $view = View::make('backend.admin.admin.create', compact('roles'))->render();
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
            if (auth()->user()->can('admin_create')) {
                $rules = [
                    'name' => 'required',
                    'email' => 'required|unique:admins,email',
                    'gender' => 'required',
                    'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                    'role_id' => 'required',
                    // 'image' => 'mimes:jpg,jpeg,png,webp|max:2048',

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

                        $file_path = $request->input('gender') == "Male" ? 'assets\img\avatars\male_avatar.png' : 'assets\img\avatars\female_avatar.png';

                        // if ($request->hasFile('image')) {
                        //     $extension = $request->file('image')->getClientOriginalExtension();;
                        //     if ($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "pdf") {
                        //         if ($request->file('image')->isValid()) {
                        //             $destinationPath = public_path('assets/img/admin_images'); // upload path
                        //             $fileName = time() . '.' . $extension; // renameing image
                        //             $file_path = 'assets/img/admin_images/' . $fileName;
                        //             $request->file('image')->move($destinationPath, $fileName);
                        //         } else {
                        //             return response()->json([
                        //                 'type' => 'error',
                        //                 'message' => "<div class='alert alert-warning'>File is not valid</div>"
                        //             ]);
                        //         }
                        //     } else {
                        //         return response()->json([
                        //             'type' => 'error',
                        //             'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
                        //         ]);
                        //     }
                        // }

                        $admin = new Admin();
                        $admin->name = $request->input('name');
                        $admin->email = $request->input('email');
                        $admin->mobile = $request->input('mobile');
                        $admin->gender = $request->input('gender');
                        $admin->image = $file_path;
                        $admin->password = Hash::make('123456');
                        $admin->save();

                        // generate role
                        $roles = $request->input('role_id');
                        if (isset($roles)) {
                            $all_roles = array_map('intval', $request->input('role_id'));
                            $admin->syncRoles($all_roles);
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
    public function show(Request $request, Admin $admin)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('admin_read')) {
                $view = View::make('backend.admin.admin.view', compact('admin'))->render();
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
    public function edit(Request $request, Admin $admin)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('admin_update')) {
                $roles = Role::all();
                $view = View::make('backend.admin.admin.edit', compact('admin', 'roles'))->render();
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
    public function update(Request $request, Admin $admin)
    {

        if ($request->ajax()) {
            if (auth()->user()->can('admin_update')) {
                $rules = [
                    'name' => 'required',
                    'email' => 'required|unique:admins,email,' . $admin->id,
                    'gender' => 'required',
                    'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                    'role_id' => 'required',
                    'image' => 'mimes:jpg,jpeg,png,webp|max:2048',
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

                        $file_path = $admin->image;

                        if ($request->hasFile('image')) {
                            $extension = $request->file('image')->getClientOriginalExtension();;
                            if ($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "webp") {
                                if ($request->file('image')->isValid()) {
                                    $destinationPath = public_path('assets/img/admin_images'); // upload path
                                    $fileName = time() . '.' . $extension; // renameing image
                                    $file_path = 'assets/img/admin_images/' . $fileName;
                                    $request->file('image')->move($destinationPath, $fileName);
                                } else {
                                    return response()->json([
                                        'type' => 'error',
                                        'message' => "<div class='alert alert-warning'>File is not valid</div>"
                                    ]);
                                }
                            } else {
                                return response()->json([
                                    'type' => 'error',
                                    'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
                                ]);
                            }
                        }



                        $admin->name = $request->input('name');
                        $admin->email = $request->input('email');
                        $admin->mobile = $request->input('mobile');
                        $admin->gender = $request->input('gender');
                        $admin->image = $file_path;
                        $admin->status = $request->input('status');
                        $admin->save();

                        $roles = $request->input('role_id');
                        if (isset($roles)) {
                            $all_roles = array_map('intval', $request->input('role_id'));
                            $admin->syncRoles($all_roles); //If one or more role is selected associate admin to roles
                        } else {
                            //If no role is selected remove exisiting role associated to a admin
                            $all_roles = $admin->getRoleNames();

                            foreach ($all_roles as $role) {
                                $admin->removeRole($role); //Remove all role associated with admin
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
    public function destroy(Request $request, Admin $admin)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('admin_delete')) {
                DB::beginTransaction();
                try {
                    $admin->delete();
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

    public function password(Request $request, Admin $admin)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('admin_update')) {
                $view = View::make('backend.admin.admin.password', compact('admin'))->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access this page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function passwordUpdate(Request $request, Admin $admin)
    {
        if ($request->ajax()) {

            $rules = [
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {

                try {

                    $admin->password =  Hash::make($request->input('password'));

                    $admin->save();

                    DB::commit();

                    return response()->json(['type' => 'success', 'message' => "Successfully change pasword"]);
                } catch (Exception $e) {
                    DB::rollback();
                    return response()->json(['type' => 'error', 'message' => "<div class='alert alert-danger'>" . $e->getMessage() . "</div>"]);
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function trashList(Request $request)
    {
        if (auth()->user()->can('admin_trash')) {
            $name = null;
            $email = null;
            $admins = Admin::latest('deleted_at')->onlyTrashed();
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $admins = $admins->where('name', 'like', '%' . $name . '%');
            }
            if ($request->has('email') && !empty($request->input('email'))) {
                $email = $request->email;
                $admins = $admins->where('email', 'like', '%' . $email . '%');
            }
            $admins = $admins->paginate(15);

            return view('backend.admin.admin.trash', compact('admins', 'name', 'email'));
        } else {
            $link = "admin.dashboard";
            return view('error.403', compact('link'));
        }
    }

    public function restore(Request $request, $id)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('admin_trash')) {
                $admin = Admin::withTrashed()->findOrFail($id);

                DB::beginTransaction();
                try {

                    if (!empty($admin)) {
                        $admin->restore();
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
            if (auth()->user()->can('admin_trash')) {
                DB::beginTransaction();
                try {

                    $ids = explode(",", $ids);

                    Admin::withTrashed()->whereIn('id', $ids)->restore();

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
            if (auth()->user()->can('admin_trash')) {
                $admin = Admin::withTrashed()->findOrFail($id);

                DB::beginTransaction();
                try {

                    if (!empty($admin)) {
                        $admin->forceDelete();
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
            if (auth()->user()->can('admin_trash')) {
                DB::beginTransaction();
                try {

                    $ids = explode(",", $ids);
                    Admin::withTrashed()->whereIn('id', $ids)->forceDelete();

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
