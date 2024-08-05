var dt_laporan_putus;        
function filterData(data)
{
    $.ajax({
        type: 'post',
        url: base_url+'laporan/data_laporan_putus_filter',
        data: data,
        success: function(data)
        {
            dt_laporan_putus.clear()
            dt_laporan_putus.rows.add(JSON.parse(data));
            dt_laporan_putus.draw();
        }
    });
}

function cetak()
{
    bulan = $("select[name='bulan']").val();
    tahun = $("select[name='tahun']").val();
    window.open(base_url+'laporan/cetak_laporan_putus/'+bulan+'/'+tahun);		    
}
$(document).ready(function(){
    $("#sidebar_laporan").addClass("active");
    $("#sidebar_laporan_putus").addClass("active");
    moment.locale('id');
    $.fn.dataTable.moment('LLL');
    dt_laporan_putus = $("#dt_laporan_putus").DataTable({
        dom : 'Bfrtip',
        order : [[1,'asc']],
        ajax : {
            url: base_url+'laporan/data_laporan_putus',
            dataSrc: "",
        },
        columns : [
            {data: "id"},
            {data: null, sortable: true, render: function(data,type,row,meta){
                return meta.row + meta.settings._iDisplayStart + 1;
            }},
            {data: "nomor_perkara"},
            {data: "tgl_putus"},
            {data: "jurusita_nama"},                    
            {data: "nomor_hp"},
            {data: "pesan", sortable: false},
            {data: "status"},
            {data: "dikirim"},
        ],
        columnDefs : [
            {
                targets: 0, visible: false
            },
            {
                targets: 3,
                data: "tgl_putus",
                render: function(data,type,row,meta)
                {
                    var dateObj = new Date(data);
                    var momentObj = moment(dateObj);
                    return momentObj.format('LL');
                }
            },
            {
                targets: 8,
                data: "dikirim",
                render: function(data,type,row,meta)
                {
                    var dateObj = new Date(data);
                    var momentObj = moment(dateObj);
                    return momentObj.format('LLL');
                }
            },
            {
                targets: [1,2,4],
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