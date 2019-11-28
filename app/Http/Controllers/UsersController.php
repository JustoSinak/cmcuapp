<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        $this->authorize('update', User::class);

        $users = User::with('roles')->orderBy('id', 'desc')->paginate(100);

        return view('admin.users.index',compact('users'));
    }

    public function create()
    {
        $this->authorize('update', User::class);

        $roles = Role::all();
        return view('admin.users.create')->withRoles($roles);
    }

    public function store(Request $request)
    {
        $this->authorize('update', User::class);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'lieu_naissance' => ['required', 'string', 'max:15'],
            'date_naissance' => ['date:"dd/mm/yyyy"'],
            'prenom' => ['required', 'string', 'min:6', 'max:20'],
            'telephone' => ['required', 'unique:users', 'numeric', 'digits:9'],
            'sexe' => ['required'],
            'login' => ['required', 'string', 'min:6', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $input = $request->all();
        $password = $input['password'];
        $user = new User();
        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->onmc = $request->onmc;
        $user->specialite = $request->specialite;
        $user->lieu_naissance = $request->lieu_naissance;
        $user->date_naissance = $request->date_naissance;
        $user->telephone = $request->telephone;
        $user->sexe = $request->sexe;
        $user->login = $request->login;
        $user->role_id = $request->roles;
        $user->password = Hash::make($password);
        $user->save();

        return redirect()->route('users.index')->with('success',"L'utilisateur a bien été créer");


    }

    public function edit($id)
    {
//        $this->authorize('update', $user);

        $roles = Role::all();
        $user = User::with('roles')->find($id);

        return view("admin.users.edit")->withUser($user)->withRoles($roles);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', User::class);

        $this->validateWith([
            'name' => ['required', 'string', 'max:255'],
            'lieu_naissance' => ['required', 'string', 'max:255'],
            'date_naissance' => ['date:"dd/mm/yyyy"'],
            'prenom' => ['required', 'string', 'min:6', 'max:255'],
            'telephone' => ['required'],
            'sexe' => ['required'],
            'login' => ['required', 'string', 'min:6', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $mdpuser = $request->input('password');
        $verifypass = password_verify($mdpuser, $user->password);

            $user->name = $request->name;
            $user->lieu_naissance = $request->lieu_naissance;
            $user->date_naissance = $request->date_naissance;
            $user->prenom = $request->prenom;
            $user->telephone = $request->telephone;
            $user->sexe = $request->sexe;
            $user->login = $request->login;
            $user->role_id = $request->roles;
        if ($verifypass == true)
        {
            $user->password = Hash::make($request->password);

            $user->save();
        }else{
            return redirect()->route('users.edit', $user->id)->with('error', "L'ancien mot de passe est invalide");
        }

        return redirect()->route('users.index')->with('success',"L'utilisateur a bien été modifier");
    }


    public function destroy(User $user)
    {
        $this->authorize('update', $user);

        $user->delete();

        return redirect()->route('users.index')->with('success', "L'utilisateur a bien été supprimé");
    }
}
