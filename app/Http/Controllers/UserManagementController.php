<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Throwable;

class UserManagementController extends Controller
{
    protected array $roles = ['admin', 'user', 'kasir'];
    public function __construct(protected FirestoreService $firestore) {}

    public function index(Request $request)
    {
        $q=$request->query('q'); $role=$request->query('role'); $active=$request->query('active');
        $items=$this->firestore->all('users')
            ->when($q, fn($c)=>$c->filter(fn($u)=>str_contains(strtolower($u->name.' '.$u->email), strtolower($q))))
            ->when($role, fn($c)=>$c->where('role',$role))
            ->when($active!==null && $active!=='', fn($c)=>$c->filter(fn($u)=>(bool)$u->is_active === (bool)$active))
            ->values();
        $page=LengthAwarePaginator::resolveCurrentPage(); $perPage=10;
        $users=new LengthAwarePaginator($items->forPage($page,$perPage)->values(), $items->count(), $perPage, $page, ['path'=>$request->url(),'query'=>$request->query()]);
        $roles=$this->roles;
        return view('users.index', compact('users','roles','q','role','active'));
    }
    public function create(){ $roles=$this->roles; return view('users.create',compact('roles')); }
    public function store(Request $request)
    {
        $data=$request->validate(['name'=>['required','string','max:255'],'email'=>['required','email','max:255'],'password'=>['required','string','min:8'],'role'=>['required',Rule::in($this->roles)],'is_active'=>['nullable','boolean']]);
        try{ $record=$this->firestore->auth()->createUser(['displayName'=>$data['name'],'email'=>$data['email'],'password'=>$data['password'],'disabled'=>!$request->boolean('is_active')]); $this->firestore->create('users',['uid'=>$record->uid,'name'=>$data['name'],'email'=>$data['email'],'role'=>$data['role'],'is_active'=>$request->boolean('is_active')],$record->uid); return redirect()->route('users.index')->with('success','User berhasil dibuat.'); }catch(Throwable $e){ return back()->withErrors(['email'=>'Gagal membuat user: '.$e->getMessage()])->withInput(); }
    }
    public function edit(string $user){ $user=$this->firestore->findOrFail('users',$user); $roles=$this->roles; return view('users.edit',compact('user','roles')); }
    public function update(Request $request,string $user)
    {
        $existing=$this->firestore->findOrFail('users',$user);
        $data=$request->validate(['name'=>['required','string','max:255'],'email'=>['required','email','max:255'],'password'=>['nullable','string','min:8'],'role'=>['required',Rule::in($this->roles)],'is_active'=>['nullable','boolean']]);
        try{ $payload=['displayName'=>$data['name'],'email'=>$data['email'],'disabled'=>!$request->boolean('is_active')]; if(!empty($data['password'])) $payload['password']=$data['password']; $this->firestore->auth()->updateUser($existing->id,$payload); $this->firestore->update('users',$existing->id,['name'=>$data['name'],'email'=>$data['email'],'role'=>$data['role'],'is_active'=>$request->boolean('is_active')]); return redirect()->route('users.index')->with('success','User berhasil diupdate.'); }catch(Throwable $e){ return back()->withErrors(['email'=>'Gagal update user: '.$e->getMessage()])->withInput(); }
    }
    public function toggle(string $user)
    {
        if(session('firebase_user.uid')===$user) return back()->with('error','Tidak bisa menonaktifkan akun sendiri.');
        $u=$this->firestore->findOrFail('users',$user); $new=!(bool)$u->is_active; if ($new) { $this->firestore->auth()->enableUser($u->id); } else { $this->firestore->auth()->disableUser($u->id); } $this->firestore->update('users',$u->id,['is_active'=>$new]); return back()->with('success','Status user berhasil diubah.');
    }
    public function destroy(string $user)
    {
        if(session('firebase_user.uid')===$user) return back()->with('error','Tidak bisa menghapus akun sendiri.');
        try{ $this->firestore->auth()->deleteUser($user); }catch(Throwable $e){}
        $this->firestore->delete('users',$user); return back()->with('success','User berhasil dihapus.');
    }
}
