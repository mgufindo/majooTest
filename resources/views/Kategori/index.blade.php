@extends('dashboard')

@push('css')
    <style>
        .header {
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            color: #ffffff;
            font-size: 20px;
            padding: 3px;
        }
        .btn i{
            font-size: 16px !important;
            padding: 0 !important;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div class="col-12">
                    <div class="header bg-success">
                        <h2 class="m-0">Kategori</h2>
                    </div>
                    <div class="col-12 d-flex justify-content-start mt-3 mb-3">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#my-modal"><i class="las la-plus"></i> &ensp; Kategori</button>
                    </div>
                    <div class="col-12 table-responsive">
                        <table id="kategori" class="table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Kategori</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Tambah Kategori</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambah">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justofy-content-between">
                        <button class="btn btn-default" type="button" data-dismiss="modal">cancel</button>
                        <button class="btn btn-primary" id="tambahSubmit" type="submit">insert</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#kategori').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "{{env("URL_API")."kategori"}}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama_kategori',
                        name: 'nama_kategori'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                ],
                columnDefs: [{
                    "targets": 2,
                    "render": function (data, type, row, meta) {
                        return `<a href="#${row.id}"><button class='btn btn-primary'>Edit</button></a> | <a href="#${row.id}"><button class="btn btn-danger">Hapus</button></a>`;
                    }
                }]
            });

            $("#formTambah").validate({
                rules:{
                    kategori:{
                        required: true,
                        minlength: 4
                    }
                },
                messages:{
                    kategori:{
                        required:'Kategori tidak boleh kosong',
                        minlength:'Minimal 4 karakter'
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');

                },
                submitHandler: function(form,e){
                    e.preventDefault();

                    $.ajax({
                        url: `{{env("URL_API")."kategori/insert"}}`,
                        type: 'POST',
                        data: new FormData(form),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function () {
                            $('#tambahSubmit').attr('disabled',true);
                            $('#tambahSubmit').html("loading...")
                        },
                        success: function(response) {
                            $('#formTambah')[0].reset();
                            $('#answers').html(response);
                            $('#my-modal').modal('hide')
                            $('.modal-backdrop').remove()
                        },
                        complete: function (data) {
                            $('#tambahSubmit').attr('disabled',false);
                            $('#tambahSubmit').html("insert")

                        }
                    });
                }
            })
        });
    </script>
@endpush
