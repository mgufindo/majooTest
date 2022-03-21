@extends("dashboard")
@section('content')
    <div class="container">
        <h2 style="margin-bottom: 20px">Create Product</h2>
        <div class="form-group">
            <label for="nama">Nama Produk</label>
            <input type="text" class="form-control" id="nama" placeholder="Nama Produk">
            <span class="text-danger hide" id="errorNama"></span>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi Produk</label>
            <textarea name="deskripsi" id="deskripsi" name="deksripsi" cols="30" rows="10" class="form-control"></textarea>
            <span class="text-danger hide" id="errorDeskripsi"></span>
        </div>
        <div class="form-group">
            <label for="deskripsi">Harga Produk</label>
            <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga Produk">
            <span class="text-danger hide" id="errorHarga"></span>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select id="kategoriId" class="js-states form-control">
                <option></option>
                @foreach($kategori as $k)
                    <option value="{{$k["id"]}}">{{$k["nama_kategori"]}}</option>
                @endforeach
            </select>
            <span class="text-danger hide" id="errorKategori"></span>

        </div>

        <div class="form-group">
            <form class="dropzone" id="dropzone" enctype="multipart/form-data">
                <input name="file" type="file" hidden/>
            </form>
            <span class="text-danger hide" id="errorImage"></span>
        </div>
        <button type="submit" class="btn btn-primary float-right" id="button">Submit</button>
    </div>

    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            $('input[name="harga"]').keyup(function(e)
            {
                if (/\D/g.test(this.value))
                {
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/\D/g, '');
                }
            });
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
                success: function(file, response){
                    // window.location = `{{url('product')}}`
                },
                error: function (file,response,xhr) {
                    if(xhr.status == '422') {
                        res = JSON.parse(xhr.response)
                        error = res.errors;
                        if(error.nama){
                            $('#errorNama').html(error.nama[0])
                            $('#errorNama').show()
                        }
                        if(error.harga){
                            $('#errorHarga').html(error.harga[0])
                            $('#errorHarga').show()
                        }
                        if(error.deskripsi){
                            $('#errorDeskripsi').html(error.deskripsi[0])
                            $('#errorDeskripsi').show()
                        }
                        if(error.kategoriId){
                            $('#errorKategori').html(error.kategoriId[0])
                            $('#errorKategori').show()
                        }
                        if(error.file){
                            $('#errorImage').html(error.file[0])
                            $('#errorImage').show()
                        }

                    }else{
                        swal({
                            title: "Error Server!",
                            text: "Silahkan coba beberapa saat lagi",
                            type: "error",
                        });
                        window.location = `{{url('product/create')}}`
                    }
                }
            });

            $('#button').click(function(){
                $cek = $('#dropzone').hasClass('dz-preview dz-image-preview');
                if ($cek) {
                    myDropzone.processQueue();
                } else {
                    swal({
                        title: "Error!",
                        text: 'Form cannot empty',
                        type: "error",
                    })
                }
            });
        })
    </script>
@endsection


