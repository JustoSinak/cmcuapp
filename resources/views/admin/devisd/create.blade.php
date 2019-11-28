@extends('layouts.admin')
@section('title', 'CMCU | Ajouter un devis')
@section('content')
<body>
   <div class="se-pr-con"></div>
   <div class="wrapper">
      @include('partials.side_bar')
      <!-- Page Content Holder -->
      @include('partials.header')
      <!--// top-bar -->
      @can('devis', \App\User::class)
      <div class="container">
         <h1 class="text-center">AJOUTER UN DEVIS DETAILLE</h1>
         <hr>
         @include('partials.flash_form')


          <div class="table-responsive">
              <form method="post" id="dynamic_form" action="{{ route('devisd.store') }}">
                  @csrf
                  <table class="table table-bordered table-striped">
                      <thead>
                      <tr>
                          <th>
                              Désignation
                              <button type="button" name="add_first" id="add_first" class="btn btn-success float-right">
                                  <i class="far fa-plus-square"></i>
                              </button>
                          </th>
                          <th colspan="3">
                              <select name="devis_id" class="form-control" required>
                                  <option value=""> Nom du devis</option>
                                  @foreach ($devis as $devi)
                                      <option value="{{ $devi->id }}"> {{ $devi->nom }}</option>
                                  @endforeach
                              </select>
                          </th>
                      </tr>
                      </thead>
                      <tbody>

                      </tbody>
                      <tfoot>
                      <tr>
                          <td colspan="2" align="right">&nbsp;</td>
                          <td colspan="1" align="right">&nbsp;</td>
                          <td>
                              <input type="submit" name="save" id="save" class="btn btn-primary" value="Enregistrer" />
                          </td>
                      </tr>
                      </tfoot>
                  </table>
{{--                  <input name="patient_id" value="{{ $patient->id }}" type="hidden">--}}
              </form>
          </div>

      </div>
   </div>
   @endcan
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

   <script>
       $(document).ready(function(){

           var count = 1;

           dynamic_field(count);

           function dynamic_field(number)
           {
               html = '<tr>';
               html += '' +
                   '<td>' +
                   '<input id="0" type="text" name="categorie[]" oninput="this.value = this.value.toUpperCase()" class="form-control" />' +
                   '</td>'
               ;
               html += '' +
                   '<td>' +
                   '<label for="1">Produit :</label>' +
                   '<input id="1" type="text" name="produit[]" oninput="this.value = this.value.toUpperCase()" class="form-control" />' +
                   '</td>'
               ;
               html += '' +
                   '<td>' +
                   '<label for="3">Quanité :</label>' +
                   '<input id="3" type="number" name="quantite[]" min="0" class="form-control" required/>' +
                   '</td>'
               ;
               html += '' +
                   '<td>' +
                   '<label for="3">prix :</label>' +
                   '<input id="3" type="number" name="prix_unit[]" min="0" class="form-control" required/>' +
                   '</td>'
               ;
               html += '' +
                   '<td>' +
                   '<input id="3" type="hidden" name="prix[]" min="0" class="form-control"/>' +
                   '</td>'
               ;

               tfoot = '<tfoot>';
               tfoot = '';
               if(number > 1)
               {
                   html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove"><i class="fas fa-minus"></i></button></td></tr>';
                   $('tbody').append(html);
               }
               else
               {
                   html += '<td><button type="button" name="add" id="add" class="btn btn-success"><i class="far fa-plus-square"></i></button></td></tr>';
                   $('tbody').html(html);
               }
           }

           $(document).on('click', '#add', function(){
               count++;
               dynamic_field(count);
           });

           $(document).on('click', '#add_first', function(){
               count++;
               dynamic_field(count);
           });

           $(document).on('click', '.remove', function(){
               count--;
               $(this).closest("tr").remove();
           });

       });
   </script>
</body>
@stop
