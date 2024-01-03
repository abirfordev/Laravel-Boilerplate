<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumniImport;
use App\Jobs\StoreAlumniData;
use App\Models\Alumni;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('alumni_read')) {
            $name = null;
            $email = null;
            $alumnis = Alumni::latest();
            if ($request->has('name') && !empty($request->input('name'))) {
                $name = $request->name;
                $alumnis = $alumnis->where('name', 'like', '%' . $name . '%');
            }
            if ($request->has('email') && !empty($request->input('email'))) {
                $email = $request->email;
                $alumnis = $alumnis->where('email', 'like', '%' . $email . '%');
            }
            $alumnis = $alumnis->paginate(15);

            $can_read = auth()->user()->can('alumni_read') ? "style=cursor:pointer;" : "style=display:none;";
            $can_update = auth()->user()->can('alumni_update') ? "style=cursor:pointer;" : "style=display:none;";
            $can_delete = auth()->user()->can('alumni_delete') ? "style=cursor:pointer;" : "style=display:none;";

            return view('backend.admin.alumni.index', compact('alumnis', 'name', 'email', 'can_read', 'can_update', 'can_delete'));
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
            if (auth()->user()->can('alumni_create')) {
                $view = View::make('backend.admin.alumni.create')->render();
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
            if (auth()->user()->can('alumni_create')) {
                $rules = [
                    'student_id' => 'required|unique:alumnis,student_id',
                    'name' => 'required',
                    'email' => 'required|unique:alumnis,email',
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

                        $alumni = new Alumni();
                        $alumni->student_id = $request->input('student_id');
                        $alumni->name = $request->input('name');
                        $alumni->email = $request->input('email');
                        $alumni->mobile = $request->input('mobile');
                        $alumni->gender = $request->input('gender');
                        $alumni->image = $file_path;
                        $alumni->password = Hash::make('123456');
                        // $alumni->is_default_password = 1;
                        $alumni->save();

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

    public function alumniImportCreate(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->can('alumni_import')) {
                $view = View::make('backend.admin.alumni.import')->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access this page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function alumniImportStore(Request $request)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('alumni_import');
            if ($haspermision) {

                $rules = [
                    'alumni_file' => 'required|mimes:csv,xlsx,xls'
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray()
                    ]);
                } else {

                    // alumni Import
                    if ($request->hasFile('alumni_file')) {
                        $extension = $request->file('alumni_file')->getClientOriginalExtension();
                        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                            if ($request->file('alumni_file')->isValid()) {

                                $email = 'abirdas422@gmail.com';
                                $mailData = [
                                    'title' => 'Successfully Store',
                                    'message' => 'Your file is successfully imported.'
                                ];

                                $data = [
                                    'email' => $email,
                                    'mailData' => $mailData
                                ];

                                Excel::queueImport(new AlumniImport(), $request->file('alumni_file'))->chain([
                                    new StoreAlumniData($data),
                                ]);

                                return response()->json(['type' => 'success', 'message' => "Successfully imported the file. After store all data you will be notify by mail."]);
                            } else {
                                return response()->json([
                                    'type' => 'error',
                                    'message' => "<div class='alert alert-danger'>File is not valid</div>"
                                ]);
                            }
                        } else {
                            return response()->json([
                                'type' => 'error',
                                'message' => "<div class='alert alert-danger'>Error! File type is not valid</div>"
                            ]);
                        }
                    }
                }
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
}
