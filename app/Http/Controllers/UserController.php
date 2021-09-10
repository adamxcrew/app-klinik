<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::all())
            ->addColumn('action', function ($row) {
                $btn = \Form::open(['url' => 'user/'.$row->id, 'method' => 'DELETE','style'=>'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .='<a class="btn btn-danger btn-sm" href="/user/'.$row->id.'/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        User::create($data);
        return redirect(route('user.index'))->with('message', 'Pengguna Bernama '.$request->name.' Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        return view('user.edit', $data);
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
        $data = $request->all();
        if ($request->password!=null) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data = $request->except('password');
        }
        $user = User::findOrFail($id);
        $user->update($data);
        return redirect(route('user.index'))->with('message', 'Pengguna Bernama '.$request->name.' Berhasil Diubah');
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
        return redirect(route('user.index'))->with('message', 'Pengguna Bernama '.$user->name.' Berhasil Dihapus');
    }


    public function profile()
    {
        $data['user'] = User::findOrFail(Auth::user()->id);
        return view('user.profile', $data);
    }


    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $data = $request->all();
        if ($request->password!=null) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data = $request->except('password');
        }
        $user->update($data);
        return redirect(route('user.profile'))->with('message', 'Profile Berhasil Di Update');
    }
}
