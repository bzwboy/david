<?php

namespace ott\tools\http;

use Yii;

error_reporting(E_ERROR | E_WARNING | E_PARSE);

/**
 * curl 
 */


class Curl
{
    /**
	 * [put]
	 * @param  array  $params [description]
	 * 
	 * url 		[必填] string 	请求的地址
	 * data 	[选填] array  	请求的数据，key value 对应
	 * option   [选填] array  	curl设置的选项，key value 对应
	 * body 	[选填] string    raw,默认form-data
	 * 
	 * @return [type]         [description]
	 */
	function put($params=[])
	{
		$url = $params['url'];
		$data = isset($params['data']) ? $params['data'] : [];
		$option = isset($params['option']) ? $params['option'] : [];

		if(isset($params['body']) && $params['body'] == 'raw'){
			$body = $data;
		}else{
			$body = http_build_query($data);
		}
		$get_curlopt_httpheader = $this->get_curlopt_httpheader();

	    $defaults = array(
	        CURLOPT_CUSTOMREQUEST => 'PUT',
	        CURLOPT_HEADER => 0,
	        CURLOPT_HTTPHEADER => $get_curlopt_httpheader, 
	        CURLOPT_URL => $url,
	        CURLOPT_FRESH_CONNECT => 1,
	        CURLOPT_RETURNTRANSFER => 1,
	        CURLOPT_FORBID_REUSE => 1,
	        CURLOPT_TIMEOUT => 0,
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_POSTFIELDS => $body
	    );

	    $ch = curl_init();
	    curl_setopt_array($ch, ($option + $defaults));
	    if( ! $result = curl_exec($ch))
	    {
	        trigger_error(curl_error($ch));
	    }
	    curl_close($ch);
	    return $result;
	}
    /**
	 * [delete]
	 * @param  array  $params [description]
	 * 
	 * url 		[必填] string 	请求的地址
	 * data 	[选填] array  	请求的数据，key value 对应
	 * option   [选填] array  	curl设置的选项，key value 对应
	 * body     [选填] string    raw,默认form-data
	 * 
	 * @return [type]         [description]
	 */
	function delete($params=[])
	{
		$url = $params['url'];
		$data = isset($params['data']) ? $params['data'] : [];
		$option = isset($params['option']) ? $params['option'] : [];

		if(isset($params['body']) && $params['body'] == 'raw'){
			$body = $data;
		}else{
			$body = http_build_query($data);
		}

		$get_curlopt_httpheader = $this->get_curlopt_httpheader();
	    $defaults = array(
	        CURLOPT_CUSTOMREQUEST => 'DELETE',
	        CURLOPT_HEADER => 0,
	        CURLOPT_HTTPHEADER => $get_curlopt_httpheader, 
	        CURLOPT_URL => $url,
	        CURLOPT_FRESH_CONNECT => 1,
	        CURLOPT_RETURNTRANSFER => 1,
	        CURLOPT_FORBID_REUSE => 1,
	        CURLOPT_TIMEOUT => 0,
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_POSTFIELDS => $body
	    );

	    $ch = curl_init();
	    curl_setopt_array($ch, ($option + $defaults));
	    if( ! $result = curl_exec($ch))
	    {
	        trigger_error(curl_error($ch));
	    }
	    curl_close($ch);
	    return $result;
	}
	/**
	 * [post]
	 * @param  array  $params [description]
	 * 
	 * url 		[必填] string 	请求的地址
	 * data 	[选填] array  	请求的数据，key value 对应
	 * option   [选填] array  	curl设置的选项，key value 对应
	 * body 	[选填] string    raw,默认form-data
	 * 
	 * @return [type]         [description]
	 */
	function post($params=[])
	{
		$url = $params['url'];
		$data = isset($params['data']) ? $params['data'] : [];
		$option = isset($params['option']) ? $params['option'] : [];

		if(isset($params['body']) && $params['body'] == 'raw'){
			$body = $data;
		}else{
			$body = is_array($data) ? http_build_query($data) : $data;
		}

		$get_curlopt_httpheader = $this->get_curlopt_httpheader();

	    $defaults = array(
	        CURLOPT_POST => 1,
	        CURLOPT_HEADER => 0,
	        CURLOPT_HTTPHEADER => $get_curlopt_httpheader, 
	        CURLOPT_URL => $url,
	        CURLOPT_FRESH_CONNECT => 1,
	        CURLOPT_RETURNTRANSFER => 1,
	        CURLOPT_FORBID_REUSE => 1,
	        CURLOPT_TIMEOUT => 0,
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_POSTFIELDS => $body
	    );

	    $ch = curl_init();
	    curl_setopt_array($ch, ($option + $defaults));
	    if( ! $result = curl_exec($ch))
	    {
	        trigger_error(curl_error($ch));
	    }
	    curl_close($ch);
	    return $result;
	}


	/**
	 * [get]
	 * @param  array  $params [description]
	 * 
	 * url 		[必填] string 请求的地址
	 * data 	[选填] array  请求的数据，key value 对应
	 * option   [选填] array  curl设置的选项，key value 对应
	 * 
	 * @return [type]         [description]
	 */
	function get($params=[])
	{   
		$url = $params['url'];
		$data = isset($params['data']) ? $params['data'] : [];
		$option = isset($params['option']) ? $params['option'] : [];
		$get_curlopt_httpheader = $this->get_curlopt_httpheader();
		$url = empty($data) ? $url : $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($data);
	    $defaults = array(
	        CURLOPT_URL => $url,
	        CURLOPT_HEADER => 0,
	        CURLOPT_HTTPHEADER => $get_curlopt_httpheader, 
	        CURLOPT_RETURNTRANSFER => 1,
	        CURLOPT_TIMEOUT => 0,
	        CURLOPT_SSL_VERIFYPEER => false
	    );   
	    $ch = curl_init();
	    curl_setopt_array($ch, ($option + $defaults));
	    if( ! $result = curl_exec($ch))
	    {
	        curl_error($ch);
	    }
	    curl_close($ch);
	    return $result;
	} 

	/**
	 * [get_curlopt_httpheader description]
	 * @return [type] [description]
	 */
    private function  get_curlopt_httpheader($params=[]){
    	$ip = $this->getUserIP();
    	$defaults = array(
	        "X-FORWARDED-FOR:{$ip}"
	    ); 
    	$res = array_merge($defaults,$params);
    	return $res;
    } 
	/**
     * check private IP
     * @return [true]|[false]
     */    
    private function isPrivateIp($ip) {
        $priAddrs = [
        	['10.0.0.0','10.255.255.255'],
            ['172.16.0.0','172.31.255.255'],
            ['192.168.0.0','192.168.255.255'],
            ['169.254.0.0','169.254.255.255'],
            ['127.0.0.0','127.255.255.255']
        ];

        $longIp = ip2long($ip);

        if ($longIp) {
            foreach ($priAddrs as $key=>$value) {
            	$start = $value[0];
            	$end = $value[1];
                if ($longIp >= ip2long($start) && $longIp <= ip2long($end)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 获取用户ip
     * @return [type] [description]
     */
    public function getUserIP(){
    	$res = null;
        $addrIndexs = ['HTTP_X_FORWARDED_FOR','X-Forwarded-For'];
        foreach ($addrIndexs as $key => $value) {
            if(isset($_SERVER[$value]) && $_SERVER[$value]){
            	$ips = explode(",", str_replace(' ', '', $_SERVER[$value]));
                foreach ($ips as $clientIp) {
                    if (!$this->isPrivateIp($clientIp)) {
                        return $clientIp;
                    }
                }
            }
        }
        $res = Yii::$app->request->getUserIP();
        return $res;
    }
}	