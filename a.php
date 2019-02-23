<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://vjs.zencdn.net/7.1.0/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/ie8/ie8-version/videojs-ie8.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
<video id="my-video"   class="video-js" controls preload="auto" width="640" height="264" poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
    <source id="video" src="MY_VIDEO.mp4" type='video/mp4'>
    <source src="MY_VIDEO.webm" type='video/webm'>
    <p class="vjs-no-js">
        To view this video please enable JavaScript, and consider upgrading to a web browser that
        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
</video>
<input type="hidden" id="baslangic" value="0">
<script>
    $(document).ready(function () {
        var sayac=document.getElementById("baslangic").innerText;//input ile sayaca sayı ata,kaçtan başlanacağı
        var kac_saniyede_bir=10;//veritabanıcalisacak
        var degisken1;//zamanlama
        var ip_adres;

        function sure_arttir() {
            var dizi=verileri_getir();
            if(dizi.includes("vjs-ended")){//video sona geldiğinde
                clearInterval(degisken1);//zamanlayıcıyı durdur
                degisken1=null;//zamanlayıcıyı null yap
            }
            sayac++;
            console.log(sayac);//saniyede bir sayıyor
            if(sayac%kac_saniyede_bir==0 || dizi.includes("vjs-ended")){//her istenilen zamanda bir ya da sona geldiğinde


                //VERİ TABANI İŞLEMLERİ


                console.log(ip_adres);
                console.log("veritabanına eklendi");
                //ajax kodları
            }
        }

        function video_baslat_durdur(durum){
            getUserIP(function(ip){ip_adres=ip;});//her event calisitğinda ip adresi yenileniyor
            if (durum) {
                if(!degisken1){//değişkenin değeri null değilse
                    degisken1= setInterval(sure_arttir, 1000);
                }
            }else{
                clearInterval(degisken1);
                degisken1=null;
            }
        }
        $(".vjs-play-control").mouseup(function(event) {//play butonu fare tıklama
            if(event.which!=1)return false;
            var dizi=verileri_getir();
            video_baslat_durdur(dizi.includes("vjs-paused"));
        });
        $(".vjs-play-control").keyup(function(event) {//play butonu boşluk tuşlama
            if(event.keyCode==32){
                var dizi=verileri_getir();
                video_baslat_durdur(dizi.includes("vjs-paused"));
            }
        });
        $(".vjs-big-play-button").mouseup(function(event) {//başlangıç büyük play butonu
            if(event.which!=1)return false;
            var dizi=verileri_getir();
            video_baslat_durdur(dizi.includes("vjs-paused"));
        });
        $(".vjs-poster").mouseup(function(event) {//ana sayfa ortaya tıklama
            if(event.which!=1)return false;
            if($(".vjs-poster").prop("tagName").toLowerCase()=="div"){
                var dizi=verileri_getir();
                video_baslat_durdur(dizi.includes("vjs-paused"));
            }
        });
        $(".vjs-tech").mouseup(function(event) {//video başladıktan sonra ortaya tıklama
             if(event.which!=1)return false;
            var dizi=verileri_getir();
            video_baslat_durdur(!dizi.includes("vjs-paused"));
        });
    });
    function verileri_getir(){
        var sinif=($("#my-video").attr("class"));
        var dizi=sinif.split(" ");
        return dizi;
    }

    function getUserIP(onNewIP) { //  onNewIp - your listener function for new IPs
        //compatibility for firefox and chrome
        var myPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
        var pc = new myPeerConnection({
                iceServers: []
            }),
            noop = function() {},
            localIPs = {},
            ipRegex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/g,
            key;
        function iterateIP(ip) {
            if (!localIPs[ip]) onNewIP(ip);
            localIPs[ip] = true;
        }
        //create a bogus data channel
        pc.createDataChannel("");
        // create offer and set local description
        pc.createOffer().then(function(sdp) {
            sdp.sdp.split('\n').forEach(function(line) {
                if (line.indexOf('candidate') < 0) return;
                line.match(ipRegex).forEach(iterateIP);
            });
            pc.setLocalDescription(sdp, noop, noop);
        }).catch(function(reason) {
            // An error occurred, so handle the failure to connect
        });
        //listen for candidate events
        pc.onicecandidate = function(ice) {
            if (!ice || !ice.candidate || !ice.candidate.candidate || !ice.candidate.candidate.match(ipRegex)) return;
            ice.candidate.candidate.match(ipRegex).forEach(iterateIP);
        };
    }

</script>
<script src="https://vjs.zencdn.net/7.1.0/video.js"></script>
</body>
</html>