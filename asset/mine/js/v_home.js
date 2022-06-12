$(document).ready(function(){
    $("#sidebar_home").addClass("active");
    $.ajax({
        url: "https://raw.githubusercontent.com/topyk27/snow/main/asset/mine/token/token.json",
        method: "GET",
        dataType: "JSON",
        beforeSend: function(){
            $(".loader2").show();
        },
        success: function(data)
        {
            try{
                if(nama_pa==data[nama_pa_pendek][0].nama_pa && nama_pa_pendek==data[nama_pa_pendek][0].nama_pa_pendek && tkn==data[nama_pa_pendek][0].token)
                {
                    
                }
                else
                {
                    // location.replace("<?php echo base_url('setting/awal'); ?>");
                    location.replace(base_url+'setting/awal');
                }
            }
            catch(err)
            {
                // location.replace("<?php echo base_url('setting/awal'); ?>");
                location.replace(base_url+'setting/awal');
            }
            $(".loader2").hide();
        },
        error: function(e)
        {
            $.ajax({
                // url: "<?php echo base_url('asset/mine/token/token.json'); ?>",
                url: base_url+'asset/mine/token/token.json',
                method: "GET",
                dataType: 'json',
                success: function(lokal)
                {
                    if(nama_pa==lokal[nama_pa_pendek][0].nama_pa && nama_pa_pendek==lokal[nama_pa_pendek][0].nama_pa_pendek && tkn==lokal[nama_pa_pendek][0].token)
                    {
                        
                    }
                    else
                    {
                        // location.replace("<?php echo base_url('setting/awal'); ?>");
                        location.replace(base_url+'setting/awal');
                    }
                    $(".loader2").hide();
                },
                error: function(err)
                {
                    $(".loader2").hide();
                    alert('Gagal dapat data token, harap hubungi administrator');
                }
            });
        }
    });
});