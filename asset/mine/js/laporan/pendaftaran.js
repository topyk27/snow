var dt_laporan_pendaftaran;
function filterData(data)
{
    $.ajax({
    type: 'POST',
    // url: "<?php echo base_url('laporan/data_laporan_pendaftaran_filter'); ?>",
    url: base_url+'laporan/data_laporan_pendaftaran_filter',
    data: data,
    success: function(data){
        dt_laporan_pendaftaran.clear()
        dt_laporan_pendaftaran.rows.add(JSON.parse(data));
        dt_laporan_pendaftaran.draw();
    }
    });
}
function cetak() {
    bulan = $("select[name='bulan']").val();
    tahun = $("select[name='tahun']").val();
    // window.open("<?php echo base_url('laporan/cetak_laporan_pendaftaran/'); ?>"+bulan+'/'+tahun);
    window.open(base_url+'laporan/cetak_laporan_pendaftaran/'+bulan+'/'+tahun);
}

$(document).ready(function(){
    $("#sidebar_laporan").addClass("active");
    $("#sidebar_laporan_pendaftaran").addClass("active");
    moment.locale('id');
    $.fn.dataTable.moment('LLL');
    dt_laporan_pendaftaran = $("#dt_laporan_pendaftaran").DataTable({
        dom : 'Bfrtip',
        order : [[1,'asc']],
        ajax : {
            // url: "<?php echo base_url('laporan/data_laporan_pendaftaran'); ?>",
            url: base_url+'laporan/data_laporan_pendaftaran',
            dataSrc: "",
        },
        columns : [
        {data: "id"},
        {data: null, sortable: true, render: function(data,type,row,meta){
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        {data: "nomor_perkara"},
        {data: "nama_pihak"},
        {data: "nomor_hp"},
        {data: "pesan"},
        {data: "dikirim"},
        ],
        columnDefs : [
        {
            targets : [0],
            visible : false,
        },
        {
            targets : [6],
            data : "dikirim",
            render : function(data,type,row,meta){
                var dateObj = new Date(data);
                var momentObj = moment(dateObj);
                return momentObj.format('LLL');
            }
        },
        {
            targets : [1,2,3,4,6],
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