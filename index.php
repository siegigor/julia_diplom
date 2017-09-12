<?php
/*if(file_exists('/home/tptohwig/public_html/diplom/code.cpp'))
{
    echo "da";
}
else echo "no";
echo __FILE__;*/
system('c++ ./code.cpp');
try{
exec("./code.out", $output);
print_r($output);
echo $output;
} catch(\Exception $e)
{
    echo "fuck";
}