var dt_laporan_panjar;
function filterData(data)
{
    $.ajax({
    type: 'POST',
    // url: "<?php echo base_url('laporan/data_laporan_panjar_filter'); ?>",
    url: base_url+'laporan/data_laporan_panjar_filter',
    data: data,
    success: function(data){
        dt_laporan_panjar.clear()
        dt_laporan_panjar.rows.add(JSON.parse(data));
        dt_laporan_panjar.draw();
    }
    });
}
function cetak() {
    bulan = $("select[name='bulan']").val();
    tahun = $("select[name='tahun']").val();
    // window.open("<?php echo base_url('laporan/cetak_laporan_panjar/'); ?>"+bulan+'/'+tahun);
    window.open(base_url+'laporan/cetak_laporan_panjar/'+bulan+'/'+tahun);
}

$(document).ready(function(){
    $("#sidebar_laporan").addClass("active");
    $("#sidebar_laporan_panjar").addClass("active");
    moment.locale('id');
    $.fn.dataTable.moment('LLL');
    dt_laporan_panjar = $("#dt_laporan_panjar").DataTable({
        dom : 'Bfrtip',
        order : [[1,'asc']],
        ajax : {
            // url: "<?php echo  base_url('laporan/data_laporan_panjar'); ?>",
            url: base_url+'laporan/data_laporan_panjar',
            dataSrc : "",
        },
        columns : [
        {data: "id"},
        {data: null, sortable: true, render: function(data,type,row,meta){
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        {data: "nomor_perkara"},
        {data: "nama"},
        {data: "nomor_hp"},
        {data: "psp"},
        {data: "pesan"},
        {data: "dikirim"},
        ],
        columnDefs : [
        {
            targets : [0],
            visible : false,
        },
        {
            targets : [5],
            data : "psp",
            render : function(data,type,row,meta)
            {
                var number_string = data.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0,sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                if(ribuan)
                {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah ? 'Rp. ' + rupiah : '';
            },
            class : "text-nowrap",
        },
        {
            targets : [7],
            data : "dikirim",
            render : function(data,type,row,meta){
                var dateObj = new Date(data);
                var momentObj = moment(dateObj);
                return momentObj.format('LLL');
            }
        },
        {
            targets : [1,2,3,5,7],
            responsivePriority : 1,
        }
        ],
        responsive : true,
        autoWidth: false,
    });

    $("#form_filter").on('submit', function(e){
        e.preventDefault();
        data = $(this).serialize();
        filterData(data);
    });
});