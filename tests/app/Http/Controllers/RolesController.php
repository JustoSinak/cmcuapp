<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Role;


class RolesController extends Controller
{

    public function index()
    {

        $roles = Role::orderBy('id', 'desc')->paginate(100);

        return view('admin.roles.index')->withRoles($roles);
    }

    public function create()
    {

        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:20', 'unique:roles'],
        ]);
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('roles.index')->with('success',"Votre nouveau role a bien été ajouté");
    }

    public function show($id)
    {
        $role = Role::where('id', $id)->first();
        return view('admin.roles.show')->withRole($role);
    }

    public function edit($id)
    {
        $role = Role::where('id', $id)->first();
        return view('admin.roles.edit')->withRole($role);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:20', 'unique:roles'],
        ]);
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        return redirect()->route('roles.index')->with('success',"Le role a bien été modifier");
    }

    public function destroy($id)
    {
        $role = Role::find($id);

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Le role a bien été supprimé');
    }
}
