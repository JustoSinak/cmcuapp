@extends('layouts.admin') @section('title', 'CMCU | Modifier une chambre') @section('content')

    <body>
    {{--<div class="se-pre-con"></div>--}}
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
    @include('partials.header')
    <!--// top-bar -->
        <div class="container">
            <h1 class="text-center">MODIFIER UNE CHAMBRE</h1>
            <hr>
            @include('partials.flash_form')
            <div class="col-md-6">
                <form method="post" action="{{ route('chambres.update', $chambre->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="name">numero:</label>
                        <input type="text" class="form-control" name="numero" value={{ $chambre->numero }} required/>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">CATEGORIE</label>
                        <select class="form-control" name="categorie"  id="exampleFormControlSelect1" required>
                            <option >classique</option>
                            <option>mvp</option>
                            <option>vip</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">PRIX</label>
                        <select class="form-control" name="prix"  id="exampleFormControlSelect1" value="{{ $chambre->prix }}" required>
                            <option >2500</option>
                            <option>5000</option>
                            <option>10000</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">MODIFIER</button>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection
