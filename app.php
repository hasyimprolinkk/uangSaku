<?php
session_start();

function wafCookie(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.a123456b.com/index.php/Home/Public/login.html");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $cookie = curl_exec($ch);

    $wafcookie = explode("Set-Cookie: ", $cookie)[1];
    $wafcookie = explode(" Expires", $wafcookie)[0];
    $bjadmin = explode("Set-Cookie: ", $cookie)[2];
    $bjadmin = explode(" expires", $bjadmin)[0];

    $cookies = $wafcookie . " " . $bjadmin . " ";
    
    login($cookies);
}

function login($wafcookie){

    echo "Username : ";
    $user = trim(fgets(STDIN));
    shell_exec('stty -echo');
    echo "Password : ";
    $pass = trim(fgets(STDIN));
    echo "\nMohon Tunggu Sebentar . . .\n";

    $data = "username=".$user."&password=".$pass;

    $header = array(
        "Accept: application/json, text/javascript, */*; q=0.01".
        "Accept-Language: en-US,en;q=0.9",
        "Content-Length: ". strlen($data),
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie: " . $wafcookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Public/login.html",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0",
        "X-Requested-With: XMLHttpRequest"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.a123456b.com/index.php/Home/Public/login.html");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $login = curl_exec($ch);

    $info = explode('"info":"', $login)[1];
    $info = explode('","', $info)[0];

    
    if(preg_match("/Berhasil/", $info)) {
        echo "Sukses Login\n";
        $memberCookie = array();
    
        $pecah = explode('Set-Cookie: ', $login);
        $memberCookie[0] = explode('path=/', $pecah[1])[0];
        $memberCookie[1] = explode('path=/', $pecah[2])[0];
        $memberCookie[2] = explode('path=/', $pecah[3])[0];
        $memberCookie[3] = explode('path=/', $pecah[4])[0];
        $cookie = $wafcookie . $memberCookie[0] . $memberCookie[1] . $memberCookie[2] . $memberCookie[3];
        //print_r($cookie);
        sleep(3);
        echo "Get Info . . .\n";
        sleep(2);
        getData($cookie);
	} elseif (preg_match("/Gagal/", $info)) {
        echo "Gagal login. username / password salah\n";
        exit;
    } else {
        echo "Upps, Sepertinya situs sedang down. Silahkan coba beberapa saat lagi\n";
        exit;
    }
}

function getData($cookie) {
    $header = array(
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Cookie: ". $cookie,
        "Referer: https://app.a123456b.com/index.php/Home/Index/index.html",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.a123456b.com/index.php/Home/Member/index.html");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $hasil = curl_exec($ch);

    echo "==============================================================\n";
    echo "\t\t\tDETAIL AKUN ANDA\n";
    echo "==============================================================\n";
    $nama = explode("<p class='tilte2' >", $hasil)[1];
    $nama = explode("</p>", $nama)[0];
    echo "Name\t\t\t: " . $nama;

    $ID = explode("<p class='idid'>",$hasil)[1];
    $ID = explode("</p>", $ID)[0];
    echo "\nID\t\t\t: " . $ID;

    $keuntungan_total = explode('<li><a href="/index.php/Home/Member/sale.html" style="display: block;"><p class="meme_user_xx">', $hasil)[1];
    $keuntungan_total = explode('</p><p class="meme_user_xxx">Keuntungan misi</p></a></li>', $keuntungan_total)[0];
    echo "\nKeuntungan Total\t: " . $keuntungan_total;

    $saldo_tersedia = explode('<li><a href="/index.php/Home/Member/log.html" style="display: block;"><p class="meme_user_xx">', $hasil)[1];
    $saldo_tersedia = explode('</p><p class="meme_user_xxx">Saldo tersedia</p></a></li>', $saldo_tersedia)[0];
    echo "\nSaldo Tersedia\t\t: " . $saldo_tersedia;

    $keuntungan = explode('<li><a href="/index.php/Home/Member/sale/t/1.html" style="display: block;"><p class="meme_user_xx">', $hasil)[1];
    $keuntungan = explode('</p><p class="meme_user_xxx">Keuntungan hari ini</p></a></li></ul>', $keuntungan)[0];
    echo "\nKeuntungan Hari ini\t: " . $keuntungan;

    $misi = explode('<ul><li><p class="meme_user_xx">', $hasil)[1];
    $misi = explode('</p><p class="meme_user_xxx">Misi yang bisa dilakukan</p></li>', $misi)[0];
    echo "\nSisa misi hari ini\t: " . $misi;

    $misi_selesai = explode("<span class='right'>Misi selesai:<b>", $hasil)[1];
    $misi_selesai = explode('</b></span></p>', $misi_selesai)[0];
    echo "\nMisi Selesai\t\t: " . $misi_selesai;
    echo "\n";
    echo "==============================================================\n";

    if($misi === "0" || $misi === 0) {
        echo "Tidak Ada misi hari ini / Misi sudah Selesai.\n";
        echo "==============================================================\n";
        exit; die;
    } else {
        sleep(1);
        echo "Sedang Mengambil Misi . . .\n";
        echo "==============================================================\n";
        getMisi($cookie);
    }
}

function getMisi($cookie){
    sleep(1);
    $data = "r=ajax&page=1&tlb=&pd=0";

    $header = array(
        "Accept: text/plain, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: ". strlen($data),
        "Cookie: ". $cookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/1.html",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0",
        "X-Requested-With: XMLHttpRequest"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.a123456b.com/index.php/Home/Task/lists_lb.html?lb=1");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $hasil = curl_exec($ch);
    
    $dataid = explode("data-id='", $hasil)[1];
    $dataid = explode("' apply-id", $dataid)[0];

    echo "Data ID : ". $dataid . "\n";
    ambilMisi($cookie, $dataid);
}

function ambilMisi($cookie, $dataid){

    $data = "id=". $dataid;

    $header = array(
        "Accept: application/json, text/javascript, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: ". strlen($data),
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie: ". $cookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/3.html",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0",
        "X-Requested-With: XMLHttpRequest"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.a123456b.com/index.php/Home/Task/get_task.html");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $hasil = curl_exec($ch);
    
    $info = explode('"info":"', $hasil)[1];
    $info = explode('","', $info)[0];
    $url = explode('"url":"', $hasil)[1];
    $url = explode('"}', $url)[0];

    echo "Info : " . $info . "\n";
    if (preg_match("/Level member/", $info)) {
        echo "Tunggu beberapa saat . . .\n";
        getData($cookie);
    } elseif (preg_match("/kadaluarsa/", $info)){
        echo "Mematikan Script . . .\n";
        exit;
    } elseif (preg_match("/Anda telah/", $info)){
        echo "Mengambil Apply-ID misi tersebut . . .\n";
        getApllyId($cookie);
    } else {
        echo "URL : " . $url . "\n";
        sleep(1);
        echo "Sedang Mengambil Misi, Tunggu beberapa saat . . .\n";
        sleep(10);
        claimMisi($cookie, $info);
    }
}

function getApllyId($cookie){
    sleep(1);
    $data = "r=ajax&page=1&tlb=0&pd=1";

    $header = array(
        "Accept: text/plain, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: ". strlen($data),
        "Cookie: " . $cookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/3.html",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0",
        "X-Requested-With: XMLHttpRequest"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.a123456b.com/index.php/Home/Task/lists_lb.html?lb=3");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $hasil = curl_exec($ch);
    
    $applyid = explode("apply-id='", $hasil)[1];
    $applyid = explode("' style=", $applyid)[0];

    echo "Apply-ID : " .$applyid . "\n";
    echo "Tunggu 15 detik . . .\n";
    sleep(15);
    claimMisi($cookie, $applyid);
}

function claimMisi($cookie, $applyid){
    
    $data = "id=".$applyid;

    $headers = array(
        "Accept: application/json, text/javascript, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: " . strlen($data),
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie: " . $cookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/3.html",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0",
        "X-Requested-With: XMLHttpRequest"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.a123456b.com/index.php/Home/Task/submission_task_do.html");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $claim = curl_exec($ch);

    $info = explode('"info":"', $claim)[1];
    $info = explode('","', $info)[0];
    echo "Keterangan : " . $info . "\n";
    echo "==============================================================\n";
    sleep(3);
    getMisi($cookie);
}

wafCookie();