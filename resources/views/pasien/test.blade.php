
<select name="pm_village_id" id="alamat" class="alamat form-control" style="height: 100px;" placeholder="Masukan Nama Desa"></select>

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />   
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
    });
    
    $('.alamat').select2({
        placeholder: 'Cari Nama Desa',
        ajax: {
        url: '/administratif/select2/desa',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                return {
                text: item.village_name,
                id: item.village_id
                }
            })
            };
        },
        cache: true
        }
    });
    </script>
@endpush