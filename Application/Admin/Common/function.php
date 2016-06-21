<?php

use OSS\Exception;
/*
 * http request tool
 */
/*
 * get method
 */
function get($url, $param=array()){
    if(!is_array($param)){
        throw new Exception("参数必须为array");
    }
    $p='';
    foreach($param as $key => $value){
        $p=$p.$key.'='.$value.'&';
    }
    if(preg_match('/\?[\d\D]+/',$url)){//matched ?c
        $p='&'.$p;
    }else if(preg_match('/\?$/',$url)){//matched ?$
        $p=$p;
    }else{
        $p='?'.$p;
    }
    $p=preg_replace('/&$/','',$p);
    $url=$url.$p;
    //echo $url;
    $httph =curl_init($url);
    curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($httph,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($httph, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
    
    curl_setopt($httph, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($httph, CURLOPT_HEADER,1);
    $rst=curl_exec($httph);
    curl_close($httph);
    return $rst;
}
/*
 * post json method
 */
function http_post_json($url, $jsonStr)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json; charset=utf-8',
      'Content-Length: ' . strlen($jsonStr)
    )
  );
  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return  $response;
}

/**
     * 模拟post进行url请求
     * @param string $url
     * @param string $param
*/
function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        return $data;
}


/**
     * 添加错误日志
     * @param string $action
     * @param string $model
     * @param string $data
     * @param string $data_post
*/
function addErrorLog($action = null, $model = null, $data, $data_post = '') {
  $log ['date'] = date("Y-m-d H:i:s");
  $log ['dataname'] = is_array ( $data ) ? serialize ( $data ) : $data;
  $log ['action'] = $action;
  $log ['model'] = $model;
  $log ['data'] = is_array ( $data_post ) ? serialize ( $data_post ) : $data_post;
  M ( 'errorlog' )->add ( $log );
}



/**
     * 阿里云Oss上传图片
     * @param string $object   文件名称
     * @param string $content
*/
function ImgOssUpload($picname, $content) {
        $accessKeyId = C('OSS_ACCESS_KEY_ID');
        $accessKeySecret = C('OSS_ACCESS_KEY_SECRET');
        $endpoint = C('OSS_ENDPOINT');
        $bucket = C('OSS_BUCKET');
        $object = $picname;
        //$options = array(OssClient::OSS_CHECK_MD5 => true);
        Vendor('OSS.autoload');
        try {
            $ossClient = new OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $data['module'] = 'function';
            $data['action'] = 'ImgOssUpload';
            $data['dataname'] = "ExpectionNewossClient";
            $data['data'] = $e->getMessage() ;
            addErrorLog($data['action'],$data['module'],$data['dataname'],$data['data']);  
        } catch (\Exception $e) {
            throw new Exception();            
            print $e->getMessage();
            return false;
        }
          $ossClient->setTimeout(3600 /* seconds */);
          $ossClient->setConnectTimeout(10 /* seconds */);
          $ossClient->putObject($bucket, $object, $content);
          return true;
}