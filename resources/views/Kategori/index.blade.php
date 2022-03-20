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
                        <table id="kategori" class="table w-100">
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

    <div id="my-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Edit Kategori</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEdit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justofy-content-between">
                        <button class="btn btn-default" type="button" data-dismiss="modal">cancel</button>
                        <button class="btn btn-primary" id="editSubmit" type="submit">update</button>
                    </div>
                </form>
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
            var table =  $('#kategori').DataTable({
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
                ],
                columnDefs: [{
                    "targets": 2,
                    "render": function (data, type, row, meta) {
                        return `<button class='btn btn-primary btn-sm' onClick="getDataEdit('${row.id}')" >Edit</button> &ensp; <button class="btn btn-danger btn-sm" onCLick="deleteKategori('${row.id}')">Hapus</button>`;
                    }
                }]
            });


            $("#formTambah").validate({
                rules:{
                    nama_kategori:{
                        required: true,
                        minlength: 4
                    }
                },
                messages:{
                    nama_kategori:{
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
                            table.ajax.reload()
                        },
                        complete: function (data) {
                            $('#tambahSubmit').attr('disabled',false);
                            $('#tambahSubmit').html("insert")

                        }
                    });
                }
            })

            var idEdit;
            getDataEdit = function (id) {
                idEdit=id;
                $.ajax({
                    url: `{{env("URL_API")."kategori/get-edit/"}}${id}`,
                    type:'get',
                    success:function (data) {
                        $('input[name=nama_kategori]').val(data.data.nama_kategori)
                    },
                    complete:function () {
                        $('#my-modal-edit').modal('show');
                    }
                })
            }

            $("#formEdit").validate({
                rules:{
                    nama_kategori:{
                        required: true,
                        minlength: 4
                    }
                },
                messages:{
                    nama_kategori:{
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
                        url: `{{env("URL_API")."kategori/update/"}}${idEdit}`,
                        type: 'POST',
                        data: new FormData(form),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function () {
                            $('#editSubmit').attr('disabled',true);
                            $('#editSubmit').html("loading...")
                        },
                        success: function(response) {
                            $('#formEdit')[0].reset();
                            $('#my-modal-edit').modal('hide')
                            $('.modal-backdrop').remove()
                            table.ajax.reload()
                        },
                        complete: function (data) {
                            $('#editSubmit').attr('disabled',false);
                            $('#editSubmit').html("insert")
                        }
                    });
                }
            })

            deleteKategori = function(id) {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: `{{env("URL_API")."kategori/delete"}}`,
                                type: "POST",
                                data: {
                                    id: id,
                                    _token: `{{csrf_token()}}`
                                },
                                success: function (data) {
                                    swal({
                                        title: "Deleted?",
                                        text: "Your file has been deleted.",
                                        type: "success",
                                    })
                                    table.ajax.reload()
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    alert('Gagal menghapus data');
                                }
                            });
                        }
                    });
            }
        });

    </script>
@endpush
