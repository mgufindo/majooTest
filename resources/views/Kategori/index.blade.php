@extends('dashboard')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="container">
        <div class="row">
            <h2>Kategori</h2>
            <div class="table-responsive">
                <table id="kategori" class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nama Kategori</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nama Kategori</th>
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
                $('#kategori').DataTable({
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
                            data: 'nama_kategori',
                            name: 'nama_kategori'
                        },
                    ],
                });
            });
        });
    </script>
@endsection
