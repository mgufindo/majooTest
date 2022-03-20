@extends("dashboard")
@section('content')
    <div class="container">
        <h2 style="margin-bottom: 20px">Create Product</h2>
        <div class="form-group">
            <label for="nama">Nama Produk</label>
            <input type="text" class="form-control" id="nama" placeholder="Nama Produk">
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi Produk</label>
            <textarea name="deskripsi" id="deskripsi" name="deksripsi" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="deskripsi">Harga Produk</label>
            <input type="text" class="form-control" id="harga" placeholder="Harga Produk">
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select id="kategoriId" class="js-states form-control">
                <option></option>
                @foreach($kategori as $k)
                    <option value="{{$k["id"]}}">{{$k["nama_kategori"]}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <form class="dropzone" id="dropzone" enctype="multipart/form-data">
                <input name="file" type="file" hidden/>
            </form>
        </div>
        <button type="submit" class="btn btn-primary float-right" id="button">Submit</button>
    </div>

    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            CKEDITOR.replace("deskripsi");

            $("#kategoriId").select2({
                placeholder: "Select Kategori",
                allowClear: true
            });

            var myDropzone = new Dropzone(".dropzone", {
                autoProcessQueue: false,
                maxFilesize: 1,
                url: "{{url('product/create')}}",
                headers: {
                    'x-csrf-token': `{{csrf_token()}}`,
                },
                params: () => ({
                    nama: document.querySelector('#nama').value,
                    deskripsi: CKEDITOR.instances.deskripsi.getData(),
                    harga: document.querySelector('#harga').value,
                    kategoriId: document.querySelector('#kategoriId').value,
                }),
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                init: function () {
                    window.location = `{{url('product')}}`
                }
            });

            $('#button').click(function(){
                myDropzone.processQueue();
            });
        })
    </script>
@endsection


