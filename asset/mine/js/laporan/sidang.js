var dt_laporan_sidang;
function filterData(data)
{
    $.ajax({
    type: 'POST',
    // url: "<?php echo base_url('laporan/data_laporan_sidang_filter'); ?>",
    url: base_url+'laporan/data_laporan_sidang_filter',
    data: data,
    success: function(data){
        dt_laporan_sidang.clear()
        dt_laporan_sidang.rows.add(JSON.parse(data));
        dt_laporan_sidang.draw();
    }
    });
}
function cetak() {
    bulan = $("select[name='bulan']").val();
    tahun = $("select[name='tahun']").val();
    // window.open("<?php echo base_url('laporan/cetak_laporan_sidang/'); ?>"+bulan+'/'+tahun);
    window.open(base_url+'laporan/cetak_laporan_sidang/'+bulan+'/'+tahun);
}

$(document).ready(function(){
    $("#sidebar_laporan").addClass("active");
    $("#sidebar_laporan_sidang").addClass("active");
    moment.locale('id');
    $.fn.dataTable.moment('LLL');
    dt_laporan_sidang = $("#dt_laporan_sidang").DataTable({
        dom : 'Bfrtip',
        order : [[1,'asc']],
        ajax : {
            // url: "<?php echo base_url('laporan/data_laporan_sidang'); ?>",
            url: base_url+'laporan/data_laporan_sidang',
            dataSrc: "",
        },
        columns : [
        {data: "id"},
        {data: null, sortable: true, render: function(data,type,row,meta){
            return meta.row + meta.settings._iDisplayStart + 1;
        }},
        {data: "nomor_perkara"},
        {data: "tanggal_sidang"},
        {data: "pihak"},
        {data: "nomorhp"},
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
            targets : [3],
            data : "tanggal_sidang",
            render : function(data,type,row,meta){
                var dateObj = new Date(data);
                var momentObj = moment(dateObj);
                return momentObj.format('LL');
            }
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
            targets : [1,2,3,4,5,8],
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