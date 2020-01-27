@extends('layouts.admin')

@section('title', 'CMCU | Liste des utilisateurs')

@section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">LISTE DES UTILISATEURS</h1>
        </div>
        <hr>
        <div class="container">
            <br>

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        @include('partials.flash')
                        <table id="myTable" class="table table-bordered table-striped" width="100%">
                            <thead>
                            <th>
                                ID
                            </th>
                            <th>NOM</th>
                            <th>LOGIN</th>
                            <th>ROLE</th>
                            <th>TELEPHONE</th>
                            <th>EDITER</th>
                            <th>SUPPRIMER</th>
                            </thead>
                            <tbody>

                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->login }}</td>
                                    <td>{{ $user->roles->name }}</td>
                                    {{--@foreach($users->roles as $role)--}}
                                        {{--<td>{{ $role->name  }}</td>--}}
                                    {{--@endforeach--}}
                                    <td>{{ $user->telephone }}</td>
                                    {{--<td>{{ $user->created_at->toFormattedDateString() }}</td>--}}
                                    {{--<td>{{ $user->updated_at->toFormattedDateString() }}</td>--}}
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                            @csrf @method('DELETE')
                                            <p data-placement="top" data-toggle="tooltip" title="Delete">
                                                <button type="submit" class="btn btn-danger btn-sm"  onclick="return myFunction()"><i class="fas fa-trash-alt"></i></button>
                                            </p>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        {{--{{ $users->links() }}--}}
                    </div>
                    <br>
                    <div class="text-center table_link_right">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">Ajouter un utilisateur</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <script>
        function myFunction() {
            if(!confirm("Veuillez confirmer la suppréssion de l'utilisateur"))
                event.preventDefault();
        }
    </script>
    <script src="{{ asset('admin/js/main.js') }}"></script>
    </body>
@stop
