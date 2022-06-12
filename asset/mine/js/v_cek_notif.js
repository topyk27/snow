$(document).ready(function(){
    $("#sidebar_cek_notif").addClass("active");
    var no = 0;
    // get_pesan("sidang");
    get_pesan("sidang");			

    function get_pesan(jenis)
    {
        sukses = true;
        // console.log(jenis);
        $.ajax({
            type : 'post',
            // url : "<?php echo base_url('waku/check_notif/'); ?>"+jenis,
            url : base_url+'waku/check_notif/'+jenis,
            dataType: 'json',
            success: function(data)
            {
                // console.log(data);
                var notifku = data['notif'].filter(function(el)
                    {
                        return el != null && el != "";
                    });
                // console.log('aa '+ notifku.length);
                if(notifku.length > 0)
                {
                    // console.log('a');
                    for(var i=0; i<notifku.length;i++)
                    {
                        if(notifku[i] !== null || notifku[i] !=='')
                        {
                            pesan = notifku[i];
                            for(j=0;j<notifku[i].length;j++)
                            {
                                no += 1;
                                $("tbody").append("<tr><td>"+no+"</td><td>"+pesan[j]+"</td></tr>");
                            }
                        }
                    }
                    // sukses = true;
                }
                else
                {
                    // sukses = false;
                    //entah mau dikasih apa kah ini
                    // $("tbody").append("<tr><td>Selesai</td><td>Tidak ada notifikasi lagi, diarahkan ke halaman kirim WA.</td></tr>");
                    // $(document).Toasts('create', {
                    //   class: 'bg-success',
                    //   title: 'Tidak ada notifikasi',
                    //   subtitle: 'Selesai',
                    //   body: 'Tidak ada notifikasi lagi, diarahkan ke halaman kirim WA.'
                    // });
                    // setTimeout(function(){
                    // 	window.location.replace("<?php echo base_url('waku/kirim'); ?>");
                    // },5000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                console.log(xhr.status);
                console.log(thrownError);
                sukses = false;
            },
            complete: function()
            {
                // console.log("apakah berhasil : " + sukses);
                if(!sukses)
                {
                    get_pesan(jenis);
                }
                else
                {
                    switch(jenis)
                    {
                        case "sidang" :
                        $(document).Toasts('create', {
                          class: 'bg-success',
                          title: 'Berhasil ambil data',
                          subtitle: "sidang",
                          body: 'Selanjutnya ambil data notifikasi SIPP'
                        });
                        get_pesan("notifikasisipp");
                        break;

                        case "notifikasisipp" :
                        $(document).Toasts('create', {
                          class: 'bg-success',
                          title: 'Berhasil ambil data',
                          subtitle: 'notifikasi SIPP',
                          body: 'Selanjutnya ambil data notifikasi pendaftaran'
                        });
                        get_pesan("daftar");
                        break;

                        case "daftar" :
                        $(document).Toasts('create', {
                          class: 'bg-success',
                          title: 'Berhasil ambil data',
                          subtitle: 'pendaftaran',
                          body: 'Selanjutnya ambil data notifikasi pendaftaran E-Court'
                        });
                        get_pesan("daftar_ecourt");
                        break;

                        case "daftar_ecourt" :
                        $(document).Toasts('create', {
                          class: 'bg-success',
                          title: 'Berhasil ambil data',
                          subtitle: 'pendaftaran E-Court',
                          body: 'Selanjutnya ambil data notifikasi akta cerai'
                        });
                        get_pesan("akta");
                        break;

                        case "akta" :
                        $(document).Toasts('create', {
                          class: 'bg-success',
                          title: 'Berhasil ambil data',
                          subtitle: 'akta cerai',
                          body: 'Selanjutnya ambil data notifikasi akta cerai pengacara'
                        });
                        get_pesan("akta_pengacara");
                        break;

                        case "akta_pengacara" :
                        $(document).Toasts('create', {
                          class: 'bg-success',
                          title: 'Berhasil ambil data',
                          subtitle: 'akta cerai pengacara',
                          body: 'Selanjutnya ambil data notifikasi PSP'
                        });
                        get_pesan("psp");
                        break;

                        case "psp" :
                        $(document).Toasts('create', {
                          class: 'bg-success',
                          title: 'Berhasil ambil',
                          subtitle: "PSP",
                          body: 'Selanjutnya ambil data perkara putus'
                        });
                        get_pesan("putus");
                        break;

                        case "putus" :
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Berhasil ambil',
                            subtitle: "Perkara Putus",
                            body: 'Selanjutnya ambil data tunda sidang'
                        });
                        get_pesan("tunda_sidang");
                        case "tunda_sidang" :
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Berhasil ambil',
                            subtitle: "Tunda Sidang",
                            body: 'Selanjutnya beralih ke halaman kirim'
                        });
                        setTimeout(function(){
                            // window.location.replace("<?php echo base_url('waku/kirim'); ?>");
                            window.location.replace(base_url+'waku/kirim');
                        },5000);
                        break;
                    }
                }
            }
        });
    }

    // var txt ='';
    // var waktu=0;
    // setInterval(function(){
    // 	if(waktu==120000)
    // 	{
    // 		waktu=0;
    // 		$("tbody").children().remove();
    // 	}
    // 	waktu=waktu+60000;
    // 	$.post("<?php echo base_url('waku/check_notif');?>", function(data){
    // 		var notifku = data['notif'].filter(function (el){
    // 			return el != null && el != "";
    // 		});
    // 		if(notifku.length > 0)
    // 		{
    // 			var no = 0;
    // 			for(var i = 0; i< notifku.length; i++)
    // 			{
    // 				if(notifku[i] !==null || notifku[i] !=='')
    // 				{
    // 					pesan = notifku[i];
    // 					for(j=0; j<notifku[i].length; j++)
    // 					{
    // 						no += 1;
    // 						$("tbody").append("<tr><td>"+no+"</td><td>"+pesan[j]+"</td></tr>");
    // 					}
    // 					console.log(notifku[i]);
    // 				}
    // 			}
    // 		}
    // 		else
    // 		{
    // 			$("tbody").append("<tr><td>Selesai</td><td>Tidak ada notifikasi lagi, diarahkan ke halaman kirim WA.</td></tr>");
    // 			$(document).Toasts('create', {
    // 			  class: 'bg-success',
    // 			  title: 'Tidak ada notifikasi',
    // 			  subtitle: 'Selesai',
    // 			  body: 'Tidak ada notifikasi lagi, diarahkan ke halaman kirim WA.'
    // 			});
    // 			setTimeout(function(){
    // 				window.location.replace("<?php echo base_url('waku/kirim'); ?>");
    // 			},5000);
    // 		}
    // 	}, "json");
    // }, 60000);
});