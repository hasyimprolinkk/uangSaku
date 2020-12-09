<?php

error_reporting(1);

function wafCookie($user, $pass, $ua){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.a123456b.com/index.php/Home/Public/login.html");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $cookie = curl_exec($ch);
    curl_close($ch);

    $wafcookie = explode("Set-Cookie: ", $cookie)[1];
    $wafcookie = explode(" Expires", $wafcookie)[0];
    $bjadmin = explode("Set-Cookie: ", $cookie)[2];
    $bjadmin = explode(" expires", $bjadmin)[0];

    $cookies = $wafcookie . " " . $bjadmin . " ";
    
    login($cookies, $user, $pass, $ua);
}

function userAgent(){
    $ua = array();
    $ua[0] = "Mozilla/5.0 (Linux; Android 9; LM-Q720) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Mobile Safari/537.36";
    $ua[1] = "Mozilla/5.0 (Linux; Android 10; SAMSUNG SM-A202F) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/12.1 Chrome/79.0.3945.136 Mobile Safari/537.36";
    $ua[2] = "Mozilla/5.0 (Linux; Android 10; SM-G975U) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Mobile Safari/537.36";
    $ua[3] = "Mozilla/5.0 (Linux; Android 7.1.2; Redmi 4X Build/N2G47H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Mobile Safari/537.36 OPT/2.7";
    $ua[4] = "Mozilla/5.0 (Linux; Android 9; SM-A205U) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36";
    $ua[5] = "Mozilla/5.0 (Linux; Android 8.1.0; SAMSUNG SM-J727T1) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/10.2 Chrome/71.0.3578.99 Mobile Safari/537.36";
    $ua[6] = "Mozilla/5.0 (Linux; Android 7.1.1; G8231 Build/41.2.A.0.219; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/59.0.3071.125 Mobile Safari/537.36";
    $ua[7] = "Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Mobile/15E148 Safari/604.1";
    $ua[8] = "Mozilla/5.0 (iPhone; CPU iPhone OS 13_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) GSA/137.2.345735309 Mobile/15E148 Safari/604.1";
    $ua[9] = "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1";
    $ua[10] = "Mozilla/5.0 (Apple-iPhone7C2/1202.466; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A543 Safari/419.3";
    $ua[11] = "Mozilla/5.0 (Linux; U; Android 9; it-it; Redmi Note 8 Build/PKQ1.190616.001) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.4.1-g";
    $ua[12] = "Mozilla/5.0 (Linux; U; Android 7.1.2; id-id; Redmi 5 Build/N2G47H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.4.1-g";
    $ua[13] = "Mozilla/5.0 (Linux; U; Android 10; id-id; MI 8 Lite Build/QKQ1.190910.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.6.6-gn";
    $ua[14] = "Mozilla/5.0 (Linux; U; Android 9; id-id; vivo 1904 Build/PPR1.180610.011) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.6.2-gn";
    $rand = array_rand($ua);
    return $ua[$rand];
}

function user(){
    $fn = fopen("user.txt", "r");
    $no = 1;
    while(!feof($fn)){
        $file = fgets($fn);
        $data = explode("|", $file);
        $user = $data[0];
        $pass = trim($data[1]);
        $ua = userAgent();
        $agent = explode("Mozilla/5.0 (", $ua)[1];
        $agent = explode(")", $agent)[0];
        echo "==============================================================\n";
        echo "USER $no : $user \n";
        echo "USER AGENT : $agent \n";
        echo "==============================================================\n";
        wafCookie($user, $pass, $ua);
        echo "Tunggu 1 Menit untuk mengganti ke akun selanjutnya . . .\n";
        echo "Script by https://t.me/hasyimprolinkk . . .\n";
        sleep(60);
        $no++;
    }
    echo "Done, Thanks You. Don't forget to Support me :)\n";
    echo "https://t.me/hasyimprolinkk\n";
}

function login($wafcookie, $user, $pass, $ua){

    $data = "username=".$user."&password=".$pass;

    $header = array(
        "Accept: application/json, text/javascript, */*; q=0.01".
        "Accept-Language: en-US,en;q=0.9",
        "Content-Length: ". strlen($data),
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie: " . $wafcookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Public/login.html",
        "User-Agent: ".$ua,
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
    curl_close($ch);

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
        sleep(2);
        echo "Get Info . . .\n";
        sleep(2);
        getData($cookie, $ua);
	} elseif (preg_match("/Gagal/", $info)) {
        echo "Gagal login. username / password salah\n";
    } else {
        echo "Upps, Sepertinya situs sedang down. Silahkan coba beberapa saat lagi\n";
        exit;
    }
}

function getData($cookie, $ua) {
    $header = array(
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Cookie: ". $cookie,
        "Referer: https://app.a123456b.com/index.php/Home/Index/index.html",
        "User-Agent: ". $ua
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.a123456b.com/index.php/Home/Member/index.html");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $hasil = curl_exec($ch);
    curl_close($ch);

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
        //exit; die;
    } else {
        sleep(1);
        echo ". . . Sedang Mengambil Misi . . .\n";
        echo "==============================================================\n";
        getMisi($cookie, $ua);
    }
}

function getMisi($cookie, $ua, $audit = 0){
    sleep(1);
    $data = "r=ajax&page=1&tlb=&pd=0";

    $header = array(
        "Accept: text/plain, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: ". strlen($data),
        "Cookie: ". $cookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/1.html",
        "User-Agent: ". $ua,
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
    curl_close($ch);
    
    $dataid = explode("data-id='", $hasil)[1];
    $dataid = explode("' apply-id", $dataid)[0];

    if($dataid === "" || $dataid === null || empty($dataid)){
        $audit += 1;
        if ($audit === 3) {
            echo "Gagal 3x, Kembali ke awal . . .\n"; sleep(1);
            getData($cookie, $ua);
        } else {
            echo "Tidak ada Respon, Sedang mengulang . . .\n"; sleep(1);
            getMisi($cookie, $ua, $audit);
        }
    } else {
        echo "Data ID : ". $dataid . "\n";
        ambilMisi($cookie, $dataid, $ua);
    }

}

function ambilMisi($cookie, $dataid, $ua, $audit = 0){

    $data = "id=". $dataid;

    $header = array(
        "Accept: application/json, text/javascript, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: ". strlen($data),
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie: ". $cookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/3.html",
        "User-Agent: ".$ua,
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
    curl_close($ch);
    
    $info = explode('"info":"', $hasil)[1];
    $info = explode('","', $info)[0];
    $url = explode('"url":"', $hasil)[1];
    $url = explode('"}', $url)[0];

    echo "Info : " . $info . "\n";
    if ($info === "" || $info === null || empty($info)){
        $audit += 1;
        if ($audit === 3) {
            echo "Gagal 3x, Kembali ke awal . . .\n"; sleep(1);
            getData($cookie, $ua);
        } else {
            echo "Gagal Mengambil Misi, Sedang Mengulang . . .\n"; sleep(1);
            ambilMisi($cookie, $dataid, $ua, $audit);
        }
    } elseif (preg_match("/Level member/", $info)) {
        echo "Tunggu beberapa saat . . .\n";
        getData($cookie, $ua);
    } elseif (preg_match("/kadaluarsa/", $info)){
        echo "Mematikan Script . . .\n";
        exit;
    } elseif (preg_match("/Anda telah/", $info)){
        echo "Mengambil Apply-ID misi tersebut . . .\n";
        getApllyId($cookie, $ua);
    } else {
        echo "URL : " . stripslashes($url) . "\n";
        sleep(1);
        echo "Sedang Mengambil Misi, Tunggu beberapa saat . . .\n";
        sleep(10);
        claimMisi($cookie, $info, $ua);
    }
}

function getApllyId($cookie, $ua){
    sleep(1);
    $data = "r=ajax&page=1&tlb=0&pd=0";

    $header = array(
        "Accept: text/plain, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: ". strlen($data),
        "Cookie: " . $cookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/1.html",
        "User-Agent: " . $ua,
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
    curl_close($ch);
    
    $applyid = explode("apply-id='", $hasil)[1];
    $applyid = explode("' style=", $applyid)[0];

    echo "Apply-ID : " .$applyid . "\n";
    echo "Tunggu beberapa saat . . .\n";
    sleep(5);
    claimMisi($cookie, $applyid, $ua);
}

function claimMisi($cookie, $applyid, $ua){
    
    $data = "id=".$applyid;

    $headers = array(
        "Accept: application/json, text/javascript, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: " . strlen($data),
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie: " . $cookie,
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/3.html",
        "User-Agent: ".$ua,
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
    curl_close($ch);

    $info = explode('"info":"', $claim)[1];
    $info = explode('","', $info)[0];

    echo "Keterangan : " . $info . "\n";
    echo "==============================================================\n";
    sleep(3);
    getMisi($cookie, $ua);
}

user();
