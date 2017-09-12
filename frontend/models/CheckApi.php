<?php 

namespace frontend\models;

use yii\helpers\Html;
use yii\helpers\Json;

class CheckApi
{
    private $url = 'http://api.hackerearth.com/code/run/';
    private $secret_key = 'e20a718306a8bf729db87880294ff432c5f7ef33';
    /// time_linmti
    
    public $result;
    
    
    public function getResult($tests, $solution)
    {
        //print_r($tests);
        foreach($tests as $test)
        {
            $data = [
                'client_secret' => 'e20a718306a8bf729db87880294ff432c5f7ef33',//$this->secret_key,
                'async'=> 0,
                'source'=> htmlspecialchars_decode(Html::encode($solution->code)),
                'input'=>$test->input,
                'lang'=> $solution->lang,
                'time_limit'=> 5,
                'memory_limit'=> 262144,
             ];
             $res = file_get_contents(/*$this->url*/'http://api.hackerearth.com/code/run/', false, stream_context_create([
                'http' => [
                'method'  => 'POST',
                'content' => http_build_query($data)
             ]]));  
                
             $this->result[] = Json::decode($res);
        }
        return $this->result;
    }
    public function getSuccessCount($tests)
    {
        $i=0; $success = 0;
        foreach($tests as $test)
        {
            if(trim($this->result[$i]['run_status']['output']) == trim($test->output))   
                $success++;
            $i++; 
        }
        return $success;
    }
}




?>