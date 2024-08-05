var dt_laporan_sidang_js;        
function filterData(data)
{
    $.ajax({
        type: 'post',
        url: base_url+'laporan/data_laporan_sidang_js_filter',
        data: data,
        success: function(data)
        {                    
            dt_laporan_sidang_js.clear()
            dt_laporan_sidang_js.rows.add(JSON.parse(data));
            dt_laporan_sidang_js.draw();
        }
    });
}
function cetak()
{
    bulan = $("select[name='bulan']").val();
    tahun = $("select[name='tahun']").val();
    window.open(base_url+'laporan/cetak_laporan_sidang_js/'+bulan+'/'+tahun);		    
}
$(document).ready(function(){
    $("#sidebar_laporan").addClass("active");
    $("#sidebar_laporan_sidang_js").addClass("active");
    moment.locale('id');
    $.fn.dataTable.moment('LLL');
    dt_laporan_sidang_js = $("#dt_laporan_sidang_js").DataTable({
        dom : 'Bfrtip',
        order : [[1,'asc']],
        ajax : {
            url: base_url+'laporan/data_laporan_sidang_js',
            dataSrc: "",
        },
        columns : [
            {data:'id'},
            {data: null, sortable: true, render: function(data,type,row,meta){
                return meta.row + meta.settings._iDisplayStart + 1;
            }},
            {data:'nomor_perkara'},
            {data:'ecourt',render: function(data,type,row,meta){
                return data=='0' ? 'Tidak' : 'Ya';
            }},
            {data:'tanggal_sidang'},
            {data:'jurusita_nama'},
            {data:'nomorhp'},
            {data:'status'},
            {data:'dikirim'},
        ],
        columnDefs : [
            {
                targets: 0,
                visible: false
            },
            {
                targets: 4,
                data: 'tanggal_sidang',
                render: function(data,type,row,meta)
                {
                    var dateObj = new Date(data);
                    var momentObj = moment(dateObj);
                    return momentObj.format('LL');
                }
            },
            {
                targets: 8,
                data: 'dikirim',
                render: function(data,type,row,meta)
                {
                    var dateObj = new Date(data);
                    var momentObj = moment(dateObj);
                    return momentObj.format('LLL');
                }
            },
            {
                targets: [1,2,5],
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