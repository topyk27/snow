var dt_laporan_akta;
function filterData(data)
{
    $.ajax({
    type: 'POST',
    // url: "<?php echo base_url('laporan/data_laporan_akta_filter'); ?>",
    url: base_url+'laporan/data_laporan_akta_filter',
    data: data,
    success: function(data){
        dt_laporan_akta.clear()
        dt_laporan_akta.rows.add(JSON.parse(data));
        dt_laporan_akta.draw();
    }
    });
}
function cetak() {
    bulan = $("select[name='bulan']").val();
    tahun = $("select[name='tahun']").val();
    // window.open("<?php echo base_url('laporan/cetak_laporan_akta/'); ?>"+bulan+'/'+tahun);
    window.open(base_url+'laporan/cetak_laporan_akta/'+bulan+'/'+tahun);
}

$(document).ready(function(){
    $("#sidebar_laporan").addClass("active");
    $("#sidebar_laporan_ac").addClass("active");
    moment.locale('id');
    $.fn.dataTable.moment('LLL');
    dt_laporan_akta = $("#dt_laporan_akta").DataTable({
        dom : 'Bfrtip',
        order : [[1,'asc']],
        ajax : {
            // url: "<?php echo  base_url('laporan/data_laporan_akta'); ?>",
            url: base_url+'laporan/data_laporan_akta',
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
        {data: "nomor_ac"},
        {data: "pesan"},
        {data: "status"},
        {data: "dikirim"},
        ],
        columnDefs : [
        {
            targets : [0],
            visible : false,
        },
        {
            targets : [8],
            data : "dikirim",
            render : function(data,type,row,meta){
                var dateObj = new Date(data);
                var momentObj = moment(dateObj);
                return momentObj.format('LLL');
            }
        },
        {
            targets : [1,2,3,5,8],
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