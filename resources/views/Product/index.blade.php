@extends('dashboard')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="container">
        <div class="row">
            <h2>Product</h2>
            <div class="table-responsive">
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
    <script src="http://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function () {
            $(document).ready(function () {
                var table = $('#product').DataTable({
                    "processing": true,
                    "serverSide": true,
                    responsive: true,
                    "ajax": "{{env("URL_API")."kategori"}}",
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

                        }
                    ],
                });
                new $.fn.dataTable.FixedHeader( table );
            });
        });
    </script>
@endsection
