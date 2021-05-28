<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{  
    public function __construct()
    {
       $this->middleware('admin')->except(['show','index']);
       $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $users=User::orderBy('created_at','DESC')->paginate(10);
        return view('/user/index')->with(['users'=>$users]);   
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name'=>'required',
            'email'=> 'required',
            ]);
        $user=new User([
            'name'=>$request['name'],
            'email'=>$request->email,
            'user_id'=>auth()->id(),
        ]);
        $user->save();
        return $this->index()->with([
            'mes_suc' => 'User '. $user->name .' is added succesfully'
        ]);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('/user/show')->with(
            ['user' => $user
            ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('/user/edit')->with(
            ['user' => $user
            ]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate(['name'=>'required',
        'email' => 'required',
        ]);
    
        $user->update([
        'name'=>$request['name'],
        'email'=>$request->email
    ]);
    return redirect('/home'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_unless($user->role='admin',403);
        $old=$user->name;
        $user->delete();
        return $this->index();
        // ->with([
        //     'mes_suc' => 'User '. $old .' is deleted succesfully'
        //]);

    }
}
