<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body>
	<h1>SERVER SMS/NOTIFIKASI  runningsss....</h1>
	<div class="notif">
	</div>
</body>
	<script type="text/javascript">
	    $("document").ready(function(){
	      var txt ='';
	      var waktu=0;
	        setInterval(function() {
	           if (waktu==120000) {
	               waktu=0;
	                $(".notif").html("");
	           }
	           waktu=waktu+60000;
	            $.post("<?php echo base_url('waku/check_notif');?>", function( data ){
	                var notifku = data['notif'].filter(function (el) {
	                    return el != null && el != "";
	                });
	                if (notifku.length > 0 ){
	                    for (var i = 0; i< notifku.length; i++) {
	                        if (notifku[i] !==null || notifku[i] !=='' ) {
	                            txt= "<b>"+notifku[i]+"</b><br>";
	                            $(".notif").append(txt);
	                            console.log(txt);
	                        }
	                    }

	                } else {
	                    // $(".notif").append("Tidak ada yang dinotifikasi/sms......<br>");
	                    // console.log("Tidak ada yang dinotifikasi/sms.....<br>");
	                    $(".notif").append("Tidak ada yang dinotifikasi/wa. Diarahkan ke halaman kirim<br>");
	                    console.log("Tidak ada yang dinotifikasi/wa. Diarahkan ke halaman kirim<br>");
	                    setTimeout(function(){
	                    	window.location.replace("<?php echo base_url('waku/kirim'); ?>");
	                    },5000);
	                }
	            }, "json");
	        }, 60000);
	    });
	</script>
</html>