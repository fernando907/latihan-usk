<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class APIUserController extends Controller
{
    /**
     * Display a data / listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id = null)
    {
        if (isset($id)) {
            $user = User::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $user], 200);
        } else {
            $user = User::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $user], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_admin(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date("Y-m-d");
        $generate_code = "";

        if ($request->role === 'admin') {
            $generate_code = 'ADM' . substr(md5(random_int(1, 8605)), 0, 17);
        } else {
            $generate_code = 'USR' . substr(md5(random_int(1, 8605)), 0, 17);
        }

        // Stored data validation
        $rules = [
            'fullname' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json(
                [
                    'message' => $errors
                ],
                400
            );
        }

        $user = User::create([
            'kode' => $generate_code,
            'nis' => $request->nis,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'photo' => $request->photo,
            'verif' => "verified",
            'role' => $request->role,
            'join_date' => $date,
            'terakhir_login' => null,
        ]);
        return response()->json(['msg' => 'Data created', 'data' => $user], 201);
    }
    public function store_user(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date("Y-m-d");

        $generate_code = 'USR' . substr(md5(random_int(1, 8605)), 0, 17);

        // Stored data validation
        $rules = [
            'fullname' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json(
                [
                    'message' => $errors
                ],
                400
            );
        }

        $user = User::create([
            'kode' => $generate_code,
            'nis' => $request->nis,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'photo' => $request->photo,
            'verif' => "unverified",
            'role' => 'user',
            'join_date' => $date,
            'terakhir_login' => null,
        ]);
        return response()->json(['msg' => 'Data created', 'data' => $user], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Stored data validation
        $rules = [
            'fullname' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json(
                [
                    'message' => $errors
                ],
                400
            );
        }

        $data = tap(User::where('id', $id))
            ->update([
                'role' => $request->role,
                'nis' => $request->nis,
                'fullname' => $request->fullname,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'photo' => $request->photo,
            ])
            ->first();

        if ($data != null) {
            return response()->json(
                [
                    "message" => "Data Updated",
                    "data" => $data
                ],
                200
            );
        }
        return response()->json(
            [
                "message" => "Failed Update Data",
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }

    // AUTHENTICATION
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('username', $request['username'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi ' . $user->fullname . ', welcome to mobile legend', 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function storeAdmin(Request $request)
    {
        // Validating Data that stored
        $rules = [
            'fullname' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json(
                [
                    'message' => $errors
                ],
                400
            );
        }

        // Creating Data
        try {
            $admin = User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => "admin",
                'join_date' => Carbon::now(),
                'verif' => 'verified',
                'kode' => 'AA' . $request->id
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    "message" => $e
                ],
                400
            );
        }

        // Response Json
        $created = User::findorFail($admin->id);

        $data = [];

        $data['id'] = $created->id;
        $data['fullname'] = $created->fullname;
        $data['username'] = $created->username;

        return response()->json(
            [
                "message" => "Data Created",
                "data" => $data
            ],
            201
        );
    }
}
