@extends("dashboard")
@section('content')
    <div class="container">
        <h2 style="margin-bottom: 20px">Update Product</h2>
        <div class="form-group">
            <label for="nama">Nama Produk</label>
            <input type="text" class="form-control" value="{{$data['nama_produk']}}" id="nama" placeholder="Nama Produk">
            <span class="text-danger hide" id="errorNama"></span>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi Produk</label>
            <textarea name="deskripsi" id="deskripsi" name="deksripsi" cols="30" rows="10" class="form-control">{!! $data['deskripsi_produk'] !!}</textarea>
            <span class="text-danger hide" id="errorDeskripsi"></span>
        </div>
        <div class="form-group">
            <label for="deskripsi">Harga Produk</label>
            <input type="text" class="form-control" name="harga" id="harga" value="{{$data['harga_produk']}}" placeholder="Harga Produk">
            <span class="text-danger hide" id="errorHarga"></span>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select id="kategoriId" class="js-states form-control">
                <option></option>
                @foreach($kategori as $k)
                    @if($k['id'] == $data['kategori_id'])
                        <option value="{{$k["id"]}}" selected>{{$k["nama_kategori"]}}</option>
                    @else
                        <option value="{{$k["id"]}}" >{{$k["nama_kategori"]}}</option>
                    @endif
                @endforeach
            </select>
            <span class="text-danger hide" id="errorKategori"></span>

        </div>

        <div class="form-group">
            <form class="dropzone" id="dropzone" enctype="multipart/form-data">
                <input name="file" type="file" hidden/>
            </form>
            <input name="image" type="text" value="{{$data['image']}}" hidden/>
            <span class="text-danger hide" id="errorImage"></span>
        </div>
        <button type="submit" class="btn btn-primary float-right" id="button">Submit</button>
    </div>

    <script type="text/javascript">
        const id = `{{ $data['id'] }}`
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
                url: "{{url('product/update')}}/"+id,
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

                    }else if(xhr.status == '501'){
                        swal({
                            title: "Error!",
                            text: res.message,
                            type: "error",
                        })
                    }
                    else{
                        swal({
                            title: "Error Server!",
                            text: "Silahkan coba beberapa saat lagi",
                            type: "error",
                        })
                    }
                }
            });

            $('#button').click(function(){

                cek = $('#dropzone').hasClass('dz-preview dz-image-preview');
                if(cek){
                    // myDropzone.processQueue();
                }else{
                    datas = {
                        nama: document.querySelector('#nama').value,
                        deskripsi: CKEDITOR.instances.deskripsi.getData(),
                        harga: document.querySelector('#harga').value,
                        kategoriId: document.querySelector('#kategoriId').value,
                        '_token' : `{{csrf_token()}}`
                    }
                    $.ajax({
                        url:'{{url('product/update')}}/'+id,
                        type:'POST',
                        data: datas,
                        beforeSend: function () {
                            $('#button').html('Loading...')
                            $('#button').attr('disabled',true)
                        },
                        success:function(data){
                            swal({
                                title: "Update!",
                                text: "Your file has been updated.",
                                type: "success",
                            }).then((result) => {
                                if(result.value){
                                    window.location = `{{url('product')}}`
                                }
                            })
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR)
                            res = jqXHR.responseJSON
                            if(jqXHR.status == 422){
                                swal({
                                    title: "Error!",
                                    text: res.message,
                                    type: "error",
                                })
                            }else if(jqXHR.status == 501){
                                swal({
                                    title: "Error!",
                                    text: res.message,
                                    type: "error",
                                })
                            }else{
                                swal({
                                    title: "Error Server!",
                                    text: "Silahkan coba beberapa saat lagi",
                                    type: "error",
                                })
                            }
                        },
                        complete: function (param) {
                            $('#button').html('Submit')
                            $('#button').attr('disabled',false)
                        }

                    })
                }
            });
        })
    </script>
@endsection


