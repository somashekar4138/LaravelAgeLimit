<?php

namespace App\Http\Controllers;
use App\Models\Register;
use App\Models\Post;

use App\Models\Hash;
use DB;

use Illuminate\Http\Request;

class userController extends Controller
{
    //
    public function registerValidator(Request $request){
        $validate = $request->validate([
            'fname' => "required|min:5",
            'lname' => "required",
            'email' => "required|email|unique:Registers,email",
            'password' => "required|min:5|max:12",
        ]);
        
        if($validate){
            $register = new Register;
            $register->fname = $request->input('fname');
            $register->lname = $request->input('lname');
            $register->Email = $request->input('email');
            $register->Password = md5($request->input('password'));
            $put=$register->save();
            if($put){
                return redirect("/register")->with("status","Register Successfully, Now Login");
            }
        } 
    }
    public function loginValidator(Request $request){
        $validate = $request->validate([
            'email' => "required|email",
            'password' => "required|min:5|max:12",
        ]);
        if($validate){
        $user=Register::where('email','=',$request->email)->first();
        if($user){
            $a=md5($request->password);
            $b=$user->Password;
            $c=$user->fname;
            $e=$user->lname;
            $as=$user->Is_Admin;
            $bs=$user->Is_Blocked;


            if($a == $b){
                $request->session()->put('fname',$c);
                $request->session()->put('lname',$e);
                $request->session()->put('as',$as);
                $request->session()->put('bs',$bs);
                return back()->with('status','login successful');
            }
            else{
                return back()->with('err','password doesnt match');
            }
        }
        else{
            return back()->with('err','Email Not Found');
        }
    }
}
public function editprofile(){
    $a=session('fname');
    $b=session('as');
    if($b=='1'){
        $users = DB::select('select * from registers where fname = ?',[$a]);
    return view('admin/adminedit',['users'=>$users]);
    }else{
    $users = DB::select('select * from registers where fname = ?',[$a]);
    return view('editprofile',['users'=>$users]);}
}
public function news(Request $request){
    $validate = $request->validate([
        'title' => "required",
        'body' => "required",
    ]);
    if($validate){
        $post = new Post;
        $post->Title = $request->input('title');
        $post->Description = $request->input('body');
        $post->Category = $request->input('category');
        $post->Author = $request->input('author');
        $put=$post->save();
            if($put){
                return redirect("/addpost")->with("status","Added Successfully");
            }
    }
}
public function update(Request $request){
    $validate = $request->validate([
        'title' => "required",
        'body' => "required",
    ]);
    if($validate){
        $id = $request->input('id');
        $Title = $request->input('title');
        $Description = $request->input('body');
        $Category = $request->input('category');
        $Author = $request->input('author');
        DB::update('update Posts set Title=?,Description=?,category=?,Author=? where id = ?',[$Title,$Description,$Category,$Author,$id]);
        return back()->with('status','Updated Successfully');
    }
}
    public function List(){
        $users = DB::select('select * from registers');
        return view('list',['users'=>$users]);
    }
    public function sdelete($id){
        $a="Soft Deleted";
        $users = DB::select('select * from Posts where Id = ?',[$id]);
        DB::update('update Posts set Status = ? where id = ?',[$a,$id]);
        return back()->with('status',"Delete Successfully");
    
    }
    public function restore($id){
        $a="no";
        DB::update('update Posts set Status = ? where id = ?',[$a,$id]);
        return back()->with('status',"Restore Successfully");
    }
    public function edit($id){
        $users = DB::select('select * from Posts where Id = ?',[$id]);
        return view('addpost2',['users'=>$users]);
    }
    public function allpost(){
        $a=session('fname');
        $users = DB::select('select * from Posts where Author = ?',[$a]);
        return view('allpost',['users'=>$users]);
    } 
    public function deletedpost(){
        $a=session('fname');
        $b="no";
        $users = DB::select('select * from Posts where Author = ? ',[$a]);
        return view('deletepost',['users'=>$users]);
    }
    public function main(){
        $a=session('fname');
        $b=session('as');
        $c=session('bs');
        if($b=="1"){
            $users = DB::select('select * from Posts');
        $usersa = DB::select('select * from registers where fname = ? ',[$a]);
            return view('admin/adminmain',['users'=>$users],['my'=>$usersa]);
        }
        else{
        $users = DB::select('select * from Posts where Author = ? ',[$a]);
        $usersadmin = DB::select('select * from Posts');
        $usersa = DB::select('select * from registers where fname = ? ',[$a]);
            return view('main',['users'=>$users],['my'=>$usersa]);
        }
    }
    public function allusers(){
        $users = DB::select('select * from registers');
        return view('admin/adminall',['users'=>$users]);
    }
    public function block($id){
        $a="1";
        DB::update('update registers set Is_Blocked = ? where id = ?',[$a,$id]);
        return back()->with('status',"Blocked Successfully");
    }
    public function unblock($id){
        $a="0";
        DB::update('update registers set Is_Blocked = ? where id = ?',[$a,$id]);
        return back()->with('status',"UnBlocked Successfully");
    }
    public function adminnews(Request $request){
        $validate = $request->validate([
            'title' => "required",
            'body' => "required",
        ]);
        if($validate){
            $post = new Post;
            $post->Title = $request->input('title');
            $post->Description = $request->input('body');
            $post->Category = $request->input('category');
            $post->Author = $request->input('author');
            $put=$post->save();
                if($put){
                    return redirect("/addpost")->with("status","Added Successfully");
                }
        }
    }
    public function adminpost(){
        $users = DB::select('select * from Posts');
        return view('admin/adminposts',['users'=>$users]);
    }
    public function publish($id){
        $a="Publish";
        $users = DB::select('select * from Posts where Id = ?',[$id]);
        DB::update('update Posts set Status = ? where id = ?',[$a,$id]);
        return back()->with('status',"Published Successfully");
    }public function unpublish($id){
        $a="Reject";
        $users = DB::select('select * from Posts where Id = ?',[$id]);
        DB::update('update Posts set Status = ? where id = ?',[$a,$id]);
        return back()->with('status',"Rejected Successfully");
    }
    public function welcome(){
       
        $users = DB::select('select * from Posts');
        return view('Welcome',['users'=>$users]);
    }
    public function read($id){
        $users = DB::select('select * from Posts where Id = ?',[$id]);
        return view('read',['users'=>$users]);
    }
}
