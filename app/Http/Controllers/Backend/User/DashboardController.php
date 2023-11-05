<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.user.dashboard');
    }

    public function profile()
    {
        $user = auth()->user();

        return view('backend.user.account-setting.profile', compact('user'));
    }

    public function profileUpdate(Request $request, $id)
    {

        if ($request->ajax()) {

            $rules = [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
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

                $user = User::findOrFail(auth()->user()->id);


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

                    $user->save();

                    DB::commit();

                    return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                } catch (Exception $e) {
                    DB::rollback();
                    return response()->json(['type' => 'error', 'message' => "<div class='alert alert-danger'>" . $e->getMessage() . "</div>"]);
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function password()
    {
        $user = auth()->user();

        return view('backend.user.account-setting.password', compact('user'));
    }

    public function passwordUpdate(Request $request, $id)
    {

        if ($request->ajax()) {

            $rules = [
                'old_password' => 'required',
                'password' => 'required|confirmed',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {

                $user = User::findOrFail(auth()->user()->id);

                if (Hash::check($request->input('old_password'), $user->password)) {
                    DB::beginTransaction();
                    try {

                        $user->password =  Hash::make($request->input('password'));

                        $user->save();

                        DB::commit();

                        return response()->json(['type' => 'success', 'message' => "Successfully change pasword"]);
                    } catch (Exception $e) {
                        DB::rollback();
                        return response()->json(['type' => 'error', 'message' => "<div class='alert alert-danger'>" . $e->getMessage() . "</div>"]);
                    }
                } else {
                    return response()->json(['type' => 'error', 'message' => "<div class='alert alert-danger'>Previous password doesn't match.</div>"]);
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function change_default_password(Request $request, $id)
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

                $user = User::findOrFail(auth()->user()->id);


                DB::beginTransaction();
                try {

                    $user->password =  Hash::make($request->input('password'));
                    $user->is_default_password = 0;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
