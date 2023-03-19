<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function users(){
        $users = Customers::orderBy('id','desc')->paginate(4);
        $total = Customers::orderBy('id','desc')->count();
        return view('users',compact('users','total'));
    }

    // INSERT

    function user_insert(){ 

         $validate = Validator::make(request()->all(),[
            'name' =>'required',
            'email' =>'required',
            'gender' =>'required',
            'address' =>'required',
        ]);

            if ($validate->fails()){
                return response()->json([
                    'errors' => $validate->errors()
                ]);
            } else   
                return response()->json([
                    'res' => Customers::create(request()->all()),
                    'success'=>'Customer has been inserted'
                ]);
           
    }

    // SEARCH AND LIST

    function user_search(Request $request){
        if($request->ajax()){
            $query = $request->get('query');
            if($query != ''){
                $data = Customers::
                        where('name','like','%'.$query.'%')
                        ->orWhere('email','like','%'.$query.'%')
                        ->orWhere('address','like','%'.$query.'%')
                        ->orWhere('gender','like','%'.$query.'%')
                        ->orderBy('id','desc')
                        ->paginate(4);
                
            }else{
                $data = Customers::
                        orderBy('id','desc')
                        ->paginate(4);
            }
             
            $blade = view('user_table',['users' => $data])->render();
            $total = $data->count();
            return response()->json([
                'data' => $data, // bu datanı networkde görmek üçün yazıram // kommet edirem hec mene lazımda deyil
                'blade' => $blade, 
                'total' => $total,
            ]);
        } else {
            $users = Customers::orderBy('id','desc')->paginate(4);
            return view('users',compact('users','total'));
        }
    }

// EDIT SHOW
    public function user_show()
    {
        return response()->json([
            'user' => Customers::find(request('user_id'))
        ]);
    }

// UPDATE
    public function user_update()
    {
      
        $validate = Validator::make(request()->all(),[
            'name' =>'required',
            'email' =>'required',
            'gender' =>'required',
            'address' =>'required'
        ]);

        if ($validate->fails()){
            return response()->json([
                'errors' => $validate->errors()->messages()
            ]);
        } else   
            return response()->json([
                'result' => Customers::where('id',request('id'))->update(request()->all()),
                'success'=>'Customer has been updated'
            ]);
    }


// DELETE
    function user_del(){
        $id = request()->user_id;
        $user = Customers::find($id);
        $user->delete();
       
        return response()->json(['success'=>'Customer has been deleted']);
    }
}
