$(document).ready(function(){
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    function saveToken(token,nama_pa,nama_pa_pendek)
    {
        $.ajax({
            // url: "<?php echo base_url('setting/savetoken'); ?>",
            url: base_url+'setting/savetoken',
            method: "POST",
            data: {token: token, nama_pa: nama_pa, nama_pa_pendek: nama_pa_pendek},
            dataType: "text",
            success: function(data)
            {
                if(data==1)
                {
                    // location.replace("<?php echo base_url(); ?>");
                    location.replace(base_url);
                }
                else
                {
                    Toast.fire({
                        icon : 'error',
                        title : 'Token gagal tersimpan.'
                    });
                }
                $(".loader2").hide();
            },
            error: function(err)
            {
                $(".loader2").hide();
                Toast.fire({
                    icon : 'error',
                    title : 'Token gagal tersimpan, harap periksa koneksi internet anda.'
                });
            }
        });
    }

    $("#verifikasi").on("submit", function(e){
        e.preventDefault();
        var token = $("input[name='token']").val();
        var nama_pa = $("input[name='nama_pa']").val();
        var nama_pa_pendek = $("input[name='nama_pa_pendek']").val();
        $.ajax({
            url: "https://raw.githubusercontent.com/topyk27/snow/main/asset/mine/token/token.json",
            method: "GET",
            dataType: "json",
            beforeSend: function()
            {
                $(".loader2").show();
            },
            success: function(data)
            {
                // console.log(data[nama_pa_pendek][0].nama_pa);
                try
                {
                    if(nama_pa==data[nama_pa_pendek][0].nama_pa && nama_pa_pendek==data[nama_pa_pendek][0].nama_pa_pendek && token==data[nama_pa_pendek][0].token)
                    {
                        // lanjutkan simpan ke data setting
                        saveToken(token,nama_pa,nama_pa_pendek);
                    }
                    else
                    {
                        Toast.fire({
                            icon : 'error',
                            title : 'Verifikasi gagal, silahkan periksa kembali data yang anda masukkan.'
                        });
                    }
                }
                catch(err)
                {
                    console.log(err);
                    Toast.fire({
                        icon : 'error',
                        title : 'Verifikasi gagal, silahkan periksa kembali data yang anda masukkan.'
                    });
                }
                $(".loader2").hide();
            },
            error: function(err)
            {
                console.log(err);
                $(".loader2").hide();
                Toast.fire({
                    icon : 'error',
                    title : 'Koneksi gagal, harap periksa jaringan internet anda atau hubungi administrator'
                });
            }
        });
    });
});