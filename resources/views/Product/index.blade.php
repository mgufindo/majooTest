@extends('dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <h2>Product</h2>
            <div class="table-responsive">
                <a href="{{url("product/create")}}" class="btn btn-dark float-right" style="margin-bottom: 30px">+
                    Create Product</a>
                <table id="product" class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nama Produk</th>
                        <th>Deksripsi Produk</th>
                        <th>Harga Produk</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nama Produk</th>
                        <th>Deksripsi Produk</th>
                        <th>Harga Produk</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#product').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "{{env("URL_API")."product/list"}}",
                columns: [
                    // mengambil & menampilkan kolom sesuai tabel database
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama_produk',
                        name: 'nama_produk'
                    },
                    {
                        data: 'deskripsi_produk',
                        name: 'deskripsi_produk'
                    },
                    {
                        data: 'harga_produk',
                        name: 'harga_produk'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                ],
                columnDefs: [
                    {
                        "aTargets": [2],
                        "mRender": function (data, type, full) {
                            return $("<div/>").html(data).text();
                        }
                    },
                    {
                        "targets": 4,
                        "render": function (data, type, row, meta) {
                            return `<a href="/product/edit-data/${row.id}"><button class='btn btn-primary')">Edit</button></a> | <button class="btn btn-danger" onclick="deleteProduct(${row.id})">Hapus</button></a>`;
                        }
                    }]
            });
        });

        function deleteProduct(id) {
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
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `{{url('product/delete')}}`,
                            type: "POST",
                            data: {
                                id: id,
                                _token: `{{csrf_token()}}`
                            },
                            success: function (data) {
                                location.reload();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert('Gagal menghapus data');
                            }
                        });
                    }
                });
        }
    </script>
@endsection
