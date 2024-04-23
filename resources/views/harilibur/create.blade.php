@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
           
            <div class="card">
                <form action="#" id="crudForm">
                <div class="card-body">
                    <form action="" method="post" >
                        <div class="modal-body">
                            {{-- <div class="row form-group">
                                <div class="col-12 col-sm-3 col-md-2">
                                    <label class="col-form-label">ID</label>
                                </div>
                                <div class="col-12 col-sm-9 col-md-10">
                                    <input type="text" name="id" class="form-control" readonly>
                                </div>
                            </div> --}}
                            <input type="text" name="id" class="form-control" hidden>
                            <div class="row form-group">
                                <div class="col-12 col-sm-3 col-md-2">
                                    <label class="col-form-label">
                                        TANGGAL<span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-sm-9 col-md-10">
                                    <div class="input-group">
                                        <input type="text" name="tgl" id="tgl" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-sm-3 col-md-2">
                                    <label class="col-form-label">
                                        Keterangan<span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-sm-9 col-md-10">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-sm-3 col-md-2">
                                    <label class="col-form-label">
                                        STATUS <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-sm-9 col-md-10">
                                    <select name="status" class="form-select select2bs4" style="width: 100%;">
                                        <option value="">-- PILIH STATUS --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button id="btnSubmit" class="btn btn-primary">
                                <i class="fa fa-save"></i>
                                Simpan
                            </button>
                            <a href="{{ route('harilibur.index') }}" class="btn btn-secondary" id="btnBatal">
                                <i class="fa fa-times"></i>
                                Tutup                            </a>
                        </div>
                    </form>
                </div>
                </form>
              </div>
        </div>
       
    </div>
</div>

{{-- @include('harilibur._modal') --}}

@push('scripts')

<script>
$(window).on('beforeunload', function() {
   
   var keterangan = $('#keterangan').val();

   var tgl = $('#tgl').val();

   localStorage.setItem('keterangan', keterangan);
   localStorage.setItem('tgl', tgl);
   
});

 
  function isiInput() {
       var keterangan = localStorage.getItem('keterangan');
       var tgl = localStorage.getItem('tgl');
       
       if (keterangan !== null && tgl !== null) {
        $('#keterangan').val(keterangan);
        $('#tgl').val(tgl);
    }
   }


     $(document).ready(function() {
        initSelect2($(`[name="status"]`),false)
        initDatepicker()

        let form = $('#crudForm')

        isiInput()
        setStatusOptions(form)
        showDefault(form)
        $('#crudForm').find('[name=tgl]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        // $('#btnBatal').click(function() {
             
        //      window.location.href = `${appUrl}/harilibur`;
        //  })

        $('#btnSubmit').click(function(event) {
           
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let hariLiburId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

          
            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}harilibur`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}harilibur/${hariLiburId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}harilibur/${hariLiburId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}harilibur`
                    break;
            }

            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: url,
                method: method,
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    id = response.data.id
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    localStorage.removeItem('keterangan');
                    localStorage.removeItem('tgl');

                    window.location.href = `${appUrl}/harilibur`;

                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON)
                    }
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })
         
       
     })

   

     const setStatusOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=status]').empty()
            relatedForm.find('[name=status]').append(
                new Option('-- PILIH STATUS --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(status => {
                        let option = new Option(status.text, status.id)

                        relatedForm.find('[name=status]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }


    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}harilibur/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        console.log(index)
                        let element = form.find(`[name="${index}"]`)
                        // let element = form.find(`[name="status"]`)

                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }
                    })
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }
</script>


@endpush()
@endsection