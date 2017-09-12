<?php
$url = 'http://api.hackerearth.com/code/compile/';
    $secret_key ='8efa22c0f2c392687c4daa29feeb75c0e41745c4'; 
    $source=htmlspecialchars("#include <iostream> using namespace std; int main() {   int a=23;  cout<<a/10<<' '<<a%10;    return 0; }");
    $data = [
            'client_secret' => $secret_key,
            'lang'=> 'CPP',
            //'source'=> htmlspecialchars("#include <iostream> using namespace std; int main() {   int a=23;  cout<<a/10<<' '<<a%10;    return 0; }"),
         ];
    print_r( http_build_query($data).'&source='.$source);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data).'&source='.$source);
    
    $result = curl_exec($ch);
    echo $result;
    print_r($result);
    curl_close($ch);