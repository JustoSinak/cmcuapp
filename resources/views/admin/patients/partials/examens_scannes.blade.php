@section('link')
<link rel="stylesheet" href="{{ asset('admin/css/examens_scannes_styles.css') }}">
@endsection
@include('partials.flash_form')
<div id="examens_scannes_form" style="display: none;">

    <div class="row ">
        @foreach($examens_scannes as $examen)
        <div class="col-md-6 mt-3">
            <div class="container_">
                <div class="button_container_add border rounded-lg ">
                    <div class="d-flex align-items-center add_button justify-content-center" data-toggle="popover" title="Description" data-content="{{ $examen->description }}" style="cursor: pointer;">
                        <img src="{{ asset('storage/'.$examen->image) }}" alt="Examen Scanné" class="image">
                    </div>
                </div>

                <div class="button_container d-flex justify-content-between">
                    <a class="btn overlay btn-outline-dark" href="{{ asset('storage/'.$examen->image) }}" target="_blank"><i class="fas fa-eye"></i></a>
                    <form action="{{ route('examens.destroy', $examen->id) }}" method="POST">
                        @csrf @method('DELETE')
                        {{ Form::hidden('patient_id', $patient->id) }}
                        <button class="btn overlay btn-outline-dark" onclick="return confirm('Voulez-vous vraiment supprimer cette image ?')" type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
                <div class="overlay description">{{ $examen->nom }}</div>
            </div>
        </div>
        @endforeach
       </div>
       <div class="pt-3 d-flex justify-content-between">
       <button class="btn btn-info " data-toggle="modal" data-target="#modal_examens_scannes" title="Ajouter une image"><i class="fas fa-plus"></i></button>
       {{ $examens_scannes->links() }}
       </div>
       

    <!-- The Modal -->
    <div class="modal fade" id="modal_examens_scannes">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter une nouvelle image</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{ route('examens.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-8">
                            {{ Form::hidden('patient_id', $patient->id) }}
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" onchange="handleFiles(files)" id="customFile" name="image">
                                    <label class="custom-file-label" for="customFile">Choisir une image</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nom" id="libelle" placeholder=" Libellé">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" id="description" name="description" placeholder="Description"></textarea>
                                </div>


                            </div>
                            <div class="col-sm-4">
                                <div>
                                    <p>
                                        <span id="preview">
                                            <img id="img1" src="{{ asset('admin/images/default.png') }}" alt="your image" width="100%" />
                                        </span>
                                    </p>

                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" title="">Ajouter</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>