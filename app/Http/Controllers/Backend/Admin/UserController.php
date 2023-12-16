<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('user_read')) {
            $name = null;
            $email = null;
            $users = User::latest();
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $users = $users->where('name', 'like', '%' . $name . '%');
            }
            if ($request->has('email') && !empty($request->input('email'))) {
                $email = $request->email;
                $users = $users->where('email', 'like', '%' . $email . '%');
            }
            $users = $users->paginate(15);

            $can_read = auth()->user()->can('user_read') ? "style=cursor:pointer;" : "style=display:none;";
            $can_update = auth()->user()->can('user_update') ? "style=cursor:pointer;" : "style=display:none;";
            $can_delete = auth()->user()->can('user_delete') ? "style=cursor:pointer;" : "style=display:none;";

            return view('backend.admin.user.index', compact('users', 'name', 'email', 'can_read', 'can_update', 'can_delete'));
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
            if (auth()->user()->can('user_create')) {
                $view = View::make('backend.admin.user.create')->render();
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
            if (auth()->user()->can('user_create')) {
                $rules = [
                    'name' => 'required',
                    'email' => 'required|unique:users,email',
                    'gender' => 'required',
                    'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
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

                        $user = new User();
                        $user->name = $request->input('name');
                        $user->email = $request->input('email');
                        $user->mobile = $request->input('mobile');
                        $user->gender = $request->input('gender');
                        $user->image = $file_path;
                        $user->password = Hash::make('123456');
                        $user->is_default_password = 1;
                        $user->save();

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
    public function show(Request $request, User $user)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('user_read')) {
                $view = View::make('backend.admin.user.view', compact('user'))->render();
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
    public function edit(Request $request, User $user)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('user_update')) {
                $view = View::make('backend.admin.user.edit', compact('user'))->render();
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
    public function update(Request $request, User $user)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('user_update')) {
                $rules = [
                    'name' => 'required',
                    'email' => 'required|unique:users,email,' . $user->id,
                    'gender' => 'required',
                    'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
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

                        $file_path = $user->image;

                        if ($request->hasFile('image')) {
                            $extension = $request->file('image')->getClientOriginalExtension();;
                            if ($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "webp") {
                                if ($request->file('image')->isValid()) {
                                    $destinationPath = public_path('assets/img/user_images'); // upload path
                                    $fileName = time() . '.' . $extension; // renameing image
                                    $file_path = 'assets/img/user_images/' . $fileName;
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

                        $user->name = $request->input('name');
                        $user->email = $request->input('email');
                        $user->mobile = $request->input('mobile');
                        $user->gender = $request->input('gender');
                        $user->image = $file_path;
                        $user->status = $request->input('status');
                        $user->save();

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
    public function destroy(Request $request, User $user)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('user_delete')) {
                DB::beginTransaction();
                try {
                    $user->delete();
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

    public function password(Request $request, User $user)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('user_update')) {
                $view = View::make('backend.admin.user.password', compact('user'))->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access this page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function passwordUpdate(Request $request, User $user)
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

                    $user->password =  Hash::make($request->input('password'));
                    $user->is_default_password = 1;
                    $user->save();

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
        if (auth()->user()->can('user_trash')) {
            $name = null;
            $email = null;
            $users = User::latest('deleted_at')->onlyTrashed();
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $users = $users->where('name', 'like', '%' . $name . '%');
            }
            if ($request->has('email') && !empty($request->input('email'))) {
                $email = $request->email;
                $users = $users->where('email', 'like', '%' . $email . '%');
            }
            $users = $users->paginate(15);

            return view('backend.admin.user.trash', compact('users', 'name', 'email'));
        } else {
            $link = "admin.dashboard";
            return view('error.403', compact('link'));
        }
    }

    public function restore(Request $request, $id)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('user_trash')) {
                $user = User::withTrashed()->findOrFail($id);

                DB::beginTransaction();
                try {

                    if (!empty($user)) {
                        $user->restore();
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
            if (auth()->user()->can('user_trash')) {
                DB::beginTransaction();
                try {

                    $ids = explode(",", $ids);

                    User::withTrashed()->whereIn('id', $ids)->restore();

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
            if (auth()->user()->can('user_trash')) {
                $user = User::withTrashed()->findOrFail($id);

                DB::beginTransaction();
                try {

                    if (!empty($user)) {
                        $user->forceDelete();
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
            if (auth()->user()->can('user_trash')) {
                DB::beginTransaction();
                try {

                    $ids = explode(",", $ids);
                    User::withTrashed()->whereIn('id', $ids)->forceDelete();

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
