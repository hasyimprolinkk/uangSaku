<?php
session_start();

function login(){

    echo "Username : ";
    $user = trim(fgets(STDIN));
    shell_exec('stty -echo');
    echo "Password : ";
    $pass = trim(fgets(STDIN));
    echo "Mohon Tunggu Sebentar . . .\n";

    $data = "username=".$user."&password=".$pass;

    $header = array(
        "Accept: application/json, text/javascript, */*; q=0.01".
        "Accept-Language: en-US,en;q=0.9",
        "Content-Length: ". strlen($data),
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie: waf_cookie=dae7d52c-56a1-4e9834023c5a1c01bbe3722cdf92715f4d95; BJYADMIN=eq3379369stoo3q6nt9t05ovb4; UM_distinctid=1763207b62e7c-0d047af2612cb7-2a687a13-100200-1763207b62f1b5; CNZZDATA1279418298=526612988-1607153579-%7C1607163339",
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Public/login.html",
        "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Mobile Safari/537.36",
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
        $cookie = array();
    
        $pecah = explode('Set-Cookie: ', $login);
        $cookie[0] = explode('path=/', $pecah[1])[0];
        $cookie[1] = explode('path=/', $pecah[2])[0];
        $cookie[2] = explode('path=/', $pecah[3])[0];
        $cookie[3] = explode('path=/', $pecah[4])[0];
        $_SESSION["cookie"] = $cookie[0] . $cookie[1] . $cookie[2] . $cookie[3];
        sleep(3);
        echo "Get Info . . .\n";
        sleep(2);
        getData($_SESSION["cookie"]);
	} else {
        echo "Gagal login. username / password salah\n";
        exit;
    }
}

function getData($cookie) {
    $header = array(
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Cookie: UM_distinctid=17618897b8346f-01fcd09619696b-930346c-100200-17618897b8467d; BJYADMIN=0se2fhibhee86mk29jras4or56; __cfduid=dac9508d509fd4adc24d877ef221dc6081606882636; waf_cookie=639e6d19-872f-4c77b0990b1de0101bd15529fb9e0876c93f; CNZZDATA1279418298=1646163775-1606728622-null%7C1607141737; ". $cookie,
        "Referer: https://app.a123456b.com/index.php/Home/Index/index.html",
        "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Mobile Safari/537.36"
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
        echo "Ada misi hari ini.\n";
        echo "==============================================================\n";
	die();
        getKompensasi($cookie);
    }
}

function ambilMisi($data){

    $data = "id=".$data;

    $header = array(
        "Accept: application/json, text/javascript, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: ". strlen($data),
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie: UM_distinctid=17618897b8346f-01fcd09619696b-930346c-100200-17618897b8467d; BJYADMIN=0se2fhibhee86mk29jras4or56; __cfduid=dac9508d509fd4adc24d877ef221dc6081606882636; waf_cookie=639e6d19-872f-4c77b0990b1de0101bd15529fb9e0876c93f; member=%7B%22id%22%3A%22134435%22%2C%22type%22%3A%221%22%2C%22is_zk%22%3A%220%22%2C%22username%22%3A%22085216850376%22%2C%22nickname%22%3A%22Agus+Indra%22%2C%22xin%22%3A%22Indra%22%2C%22email%22%3A%22%22%2C%22phone%22%3A%22%22%2C%22password%22%3A%221a20e40fa82a0999f52828e75f75e119%22%2C%22head_img%22%3A%22120.188.74.90%22%2C%22openid%22%3A%22%22%2C%22sex%22%3Anull%2C%22country%22%3Anull%2C%22province%22%3Anull%2C%22province_id%22%3Anull%2C%22city%22%3Anull%2C%22city_id%22%3Anull%2C%22area%22%3Anull%2C%22area_id%22%3Anull%2C%22access_token%22%3A%22%22%2C%22create_time%22%3A%221605351848%22%2C%22last_login_time%22%3A%221607048635%22%2C%22remark%22%3Anull%2C%22level%22%3A%220%22%2C%22role%22%3A%220%22%2C%22price%22%3A%221250.00%22%2C%22total_price%22%3A%2221250.00%22%2C%22tixian_price%22%3A%2220000.00%22%2C%22idc%22%3Anull%2C%22bank_name%22%3A%22Bank+CIMB+Niaga%22%2C%22subbranch_name%22%3A%22HASYIM+ASYARI%22%2C%22bank_user%22%3A%22Agus%22%2C%22bank_number%22%3A%228059085330256361%22%2C%22address%22%3Anull%2C%22occupation%22%3Anull%2C%22notice_num%22%3A%220%22%2C%22notice_view_time%22%3Anull%2C%22p1%22%3A%22134075%22%2C%22p2%22%3A%22130109%22%2C%22p3%22%3A%220%22%2C%22p1_num%22%3A%224%22%2C%22p2_num%22%3A%224%22%2C%22p3_num%22%3A%220%22%2C%22p_num%22%3Anull%2C%22pids%22%3A%2262719%2C62728%2C62765%2C66595%2C71404%2C71951%2C90656%2C90767%2C130109%2C134075%22%2C%22key_type%22%3A%220%22%2C%22agentid%22%3A%2260215%22%2C%22tx_status%22%3A%221%22%2C%22all_price%22%3A%2221250.00%22%2C%22no_finish_number%22%3A%220%22%2C%22finish_number%22%3A%2250%22%2C%22bank_time%22%3A%221605754092%22%2C%22dzptime%22%3A%220%22%2C%22signday%22%3A%220%22%2C%22signtime%22%3A%220%22%2C%22dwonnum%22%3A%220%22%2C%22isup%22%3A%220%22%7D; uid3=1; uid=134435; uidz=134435%7C; CNZZDATA1279418298=1646163775-1606728622-null%7C1607152538",
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/3.html",
        "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Mobile Safari/537.36",
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

    $info = explode('{"info":"', $hasil)[1];
    $info = explode('",', $info)[0];
    return "Keterangan : " . $info;
}

function getKompensasi($cookie){

    $data = "r=ajax&page=1&tlb=0&pd=1";

    $header = array(
        "Accept: text/plain, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: ". strlen($data),
        "Cookie: UM_distinctid=17618897b8346f-01fcd09619696b-930346c-100200-17618897b8467d; BJYADMIN=0se2fhibhee86mk29jras4or56; __cfduid=dac9508d509fd4adc24d877ef221dc6081606882636; waf_cookie=639e6d19-872f-4c77b0990b1de0101bd15529fb9e0876c93f; ".$cookie." CNZZDATA1279418298=1646163775-1606728622-null%7C1607152538",
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/3.html",
        "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Mobile Safari/537.36",
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
    
    $kompensasi = explode("Kwantitas misi:<span>", $hasil)[1];
    $kompensasi = explode("</span></p></div>", $kompensasi)[0];

    return $kompensasi;
}

function getApllyId(){

    $data = "r=ajax&page=1&tlb=0&pd=1";

    $header = array(
        "Accept: text/plain, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: ". strlen($data),
        "Cookie: UM_distinctid=17618897b8346f-01fcd09619696b-930346c-100200-17618897b8467d; BJYADMIN=0se2fhibhee86mk29jras4or56; __cfduid=dac9508d509fd4adc24d877ef221dc6081606882636; waf_cookie=639e6d19-872f-4c77b0990b1de0101bd15529fb9e0876c93f; member=%7B%22id%22%3A%22134435%22%2C%22type%22%3A%221%22%2C%22is_zk%22%3A%220%22%2C%22username%22%3A%22085216850376%22%2C%22nickname%22%3A%22Agus+Indra%22%2C%22xin%22%3A%22Indra%22%2C%22email%22%3A%22%22%2C%22phone%22%3A%22%22%2C%22password%22%3A%221a20e40fa82a0999f52828e75f75e119%22%2C%22head_img%22%3A%22120.188.74.90%22%2C%22openid%22%3A%22%22%2C%22sex%22%3Anull%2C%22country%22%3Anull%2C%22province%22%3Anull%2C%22province_id%22%3Anull%2C%22city%22%3Anull%2C%22city_id%22%3Anull%2C%22area%22%3Anull%2C%22area_id%22%3Anull%2C%22access_token%22%3A%22%22%2C%22create_time%22%3A%221605351848%22%2C%22last_login_time%22%3A%221607048635%22%2C%22remark%22%3Anull%2C%22level%22%3A%220%22%2C%22role%22%3A%220%22%2C%22price%22%3A%221250.00%22%2C%22total_price%22%3A%2221250.00%22%2C%22tixian_price%22%3A%2220000.00%22%2C%22idc%22%3Anull%2C%22bank_name%22%3A%22Bank+CIMB+Niaga%22%2C%22subbranch_name%22%3A%22HASYIM+ASYARI%22%2C%22bank_user%22%3A%22Agus%22%2C%22bank_number%22%3A%228059085330256361%22%2C%22address%22%3Anull%2C%22occupation%22%3Anull%2C%22notice_num%22%3A%220%22%2C%22notice_view_time%22%3Anull%2C%22p1%22%3A%22134075%22%2C%22p2%22%3A%22130109%22%2C%22p3%22%3A%220%22%2C%22p1_num%22%3A%224%22%2C%22p2_num%22%3A%224%22%2C%22p3_num%22%3A%220%22%2C%22p_num%22%3Anull%2C%22pids%22%3A%2262719%2C62728%2C62765%2C66595%2C71404%2C71951%2C90656%2C90767%2C130109%2C134075%22%2C%22key_type%22%3A%220%22%2C%22agentid%22%3A%2260215%22%2C%22tx_status%22%3A%221%22%2C%22all_price%22%3A%2221250.00%22%2C%22no_finish_number%22%3A%220%22%2C%22finish_number%22%3A%2250%22%2C%22bank_time%22%3A%221605754092%22%2C%22dzptime%22%3A%220%22%2C%22signday%22%3A%220%22%2C%22signtime%22%3A%220%22%2C%22dwonnum%22%3A%220%22%2C%22isup%22%3A%220%22%7D; uid3=1; uid=134435; uidz=134435%7C; CNZZDATA1279418298=1646163775-1606728622-null%7C1607152538",
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/3.html",
        "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Mobile Safari/537.36",
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

    return $applyid;

}

function claimMisi($idmisi){

    $data = "id=".$idmisi;

    $headers = array(
        "Accept: application/json, text/javascript, */*; q=0.01",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Content-Length: " . strlen($data),
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie: UM_distinctid=17618897b8346f-01fcd09619696b-930346c-100200-17618897b8467d; BJYADMIN=0se2fhibhee86mk29jras4or56; __cfduid=dac9508d509fd4adc24d877ef221dc6081606882636; waf_cookie=639e6d19-872f-4c77b0990b1de0101bd15529fb9e0876c93f; member=%7B%22id%22%3A%22134435%22%2C%22type%22%3A%221%22%2C%22is_zk%22%3A%220%22%2C%22username%22%3A%22085216850376%22%2C%22nickname%22%3A%22Agus+Indra%22%2C%22xin%22%3A%22Indra%22%2C%22email%22%3A%22%22%2C%22phone%22%3A%22%22%2C%22password%22%3A%221a20e40fa82a0999f52828e75f75e119%22%2C%22head_img%22%3A%22120.188.74.90%22%2C%22openid%22%3A%22%22%2C%22sex%22%3Anull%2C%22country%22%3Anull%2C%22province%22%3Anull%2C%22province_id%22%3Anull%2C%22city%22%3Anull%2C%22city_id%22%3Anull%2C%22area%22%3Anull%2C%22area_id%22%3Anull%2C%22access_token%22%3A%22%22%2C%22create_time%22%3A%221605351848%22%2C%22last_login_time%22%3A%221607048635%22%2C%22remark%22%3Anull%2C%22level%22%3A%220%22%2C%22role%22%3A%220%22%2C%22price%22%3A%221250.00%22%2C%22total_price%22%3A%2221250.00%22%2C%22tixian_price%22%3A%2220000.00%22%2C%22idc%22%3Anull%2C%22bank_name%22%3A%22Bank+CIMB+Niaga%22%2C%22subbranch_name%22%3A%22HASYIM+ASYARI%22%2C%22bank_user%22%3A%22Agus%22%2C%22bank_number%22%3A%228059085330256361%22%2C%22address%22%3Anull%2C%22occupation%22%3Anull%2C%22notice_num%22%3A%220%22%2C%22notice_view_time%22%3Anull%2C%22p1%22%3A%22134075%22%2C%22p2%22%3A%22130109%22%2C%22p3%22%3A%220%22%2C%22p1_num%22%3A%224%22%2C%22p2_num%22%3A%224%22%2C%22p3_num%22%3A%220%22%2C%22p_num%22%3Anull%2C%22pids%22%3A%2262719%2C62728%2C62765%2C66595%2C71404%2C71951%2C90656%2C90767%2C130109%2C134075%22%2C%22key_type%22%3A%220%22%2C%22agentid%22%3A%2260215%22%2C%22tx_status%22%3A%221%22%2C%22all_price%22%3A%2221250.00%22%2C%22no_finish_number%22%3A%220%22%2C%22finish_number%22%3A%2250%22%2C%22bank_time%22%3A%221605754092%22%2C%22dzptime%22%3A%220%22%2C%22signday%22%3A%220%22%2C%22signtime%22%3A%220%22%2C%22dwonnum%22%3A%220%22%2C%22isup%22%3A%220%22%7D; uid3=1; uid=134435; uidz=134435%7C; CNZZDATA1279418298=1646163775-1606728622-null%7C1607147137",
        "Origin: https://app.a123456b.com",
        "Referer: https://app.a123456b.com/index.php/Home/Task/lists_lb/lb/3.html",
        "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Mobile Safari/537.36",
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

    print_r($claim);
}


//ambilMisi("34381");
//echo getApllyId();
//$applyid = getApllyId();
//$applyid;
//claimMisi($applyid);
//getData();
// $kompensasi = getKompensasi();
// echo $kompensasi . "\n";
// $ambil = ambilMisi($kompensasi);
// echo $ambil;
login();