$("document").ready(function(){
    $("#sidebar_setting").addClass("active");
    $("#sidebar_setting_kontak").addClass("active");
    
    $("select#jabatan").on('change', function(){
        var jabatan = this.value;
        if(jabatan!="babu")
        {
            if(jabatan=="kasir")
            {
                $.ajax({
                    type: 'GET',
                    // url: "<?php echo base_url('kontak/kasir') ?>",
                    url: base_url+'kontak/kasir',
                    beforeSend: function()
                    {
                        $(".loader2").show();
                    },
                    success: function(respon)
                    {								
                        if(respon=='true')
                        {
                            $("select#nama").children().remove();
                            $("select#nama").prop("disabled",true);
                            $("select#nama").hide();
                            $("input[name='nama']").prop("disabled",false);
                            $("input[name='nama']").show();				
                        }
                        else
                        {
                            $("select#jabatan").val('babu').change();
                            toas('error','Kasir sudah terdaftar, tidak dapat ditambah lagi. Silahkan dihapus kasir sebelumnya');									
                        }
                    }
                });
            }
            else
            {
                $.ajax({
                    type: 'POST',
                    // url: "<?php echo base_url('kontak/getjabatan'); ?>",
                    url: base_url+'kontak/getjabatan',
                    data: {jabatan: jabatan},
                    dataType: 'json',
                    success: function(data)
                    {
                        $("select#nama").prop("disabled",false);
                        $("select#nama").show();
                        $("select#nama").children().remove();
                        $("select#nama").append("<option value='babi'>Pilih Pegawai</option>");
                        $.each(data['jabatan'], function(k,v){
                            $("select#nama").append("<option value='"+v.nama_gelar+"#"+v.id+"'>"+v.nama_gelar+"</option>");
                        });
                        $("input[name='nama']").prop("disabled",true);
                        $("input[name='nama']").hide();
                    },
                    error: function(err)
                    {
                        console.log(err);
                    },
                    complete: function()
                    {
                        
                    }
                });
            }
        }
        else
        {
            $("select#nama").children().remove();
            $("select#nama").append("<option value='babi'>Pilih Jabatan Terlebih Dahulu</option>");
        }
    });

    $("select#nama").on('change', function(){
        var nama = this.value;
        if(nama!="babi")
        {
            nama = nama.split("#");
            $("input#sok_ide").val(nama[1]);
        }
    });

    function toas(icon,msg)
    {
        let toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000
        });
        toast.fire({
            icon : icon,
            title : msg
        });
    }
});