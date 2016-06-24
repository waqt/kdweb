<?php


/**
 * 创建logic
 * @param string $name logic名称
 * @return Admin\Logic
 * @author liutj
 */
function logic($name) {
	$name = ucfirst($name);
    static $_logic  =   array();
    if(isset($_logic[$name]))
        return $_logic[$name];
    $class      =   '\\Logic\\' . $name . 'Logic';
    $logic      =   class_exists($class)? new $class : new \Admin\Logic\BaseLogic;
    $_logic[$name]  =  $logic;
    return $logic;
}

/**
 * 创建service
 * @param string $name service名称
 * @return Service\BaseService
 * @author liutj 
 */
function service($name) {
    $name = ucfirst($name);
    static $_service  =   array();
    if(isset($_service[$name]))
        return $_service[$name];
    $class      =   '\\Service\\' . $name . 'Service';
	$service      =   class_exists($class)? new $class : new \Service\BaseService;
    $_service[$name]  =  $service;
    return $service;
}


/**
 * 创建service
 * @param string $name service名称
 * @return Model\BaseModel
 * @author liutj
 */
function model($name) {
    $name = ucfirst(parse_name($name, 1));
    static $_model  =   array();
    if(isset($_model[$name]))
        return $_model[$name];
    $class      =   '\\Model\\' . $name . 'Model';
    $model      =   class_exists($class)? new $class : new \Think\Model($name);
    $_model[$name]  =  $model;
    return $model;
}


/**
     * 阿里云Oss上传图片
     * @param _FILE $content   文件控件
     * @return string $filepath 文件路径
*/
function UploadBeforeOss($content){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
        // 上传单个文件 
        $info   =   $upload->uploadOne($content);
        
        $filepath='./Uploads/'.$info['savepath'].$info['savename'];
        return $filepath;    
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

        Vendor('OSS.autoload');
        //$options = array(OssClient::OSS_CHECK_MD5 => true);  
        try {
            $ossClient = new OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);
            }catch (OssException  $e) {  
                throw_exception('OSS初始化失败',$e);
                return false;
            }
        try{
            $ossClient->setTimeout(3600 /* seconds */);
            $ossClient->setConnectTimeout(10 /* seconds */);
            $ossClient->uploadFile($bucket, $object, $content); 
            return true;  
          }catch (OssException  $e) { 
            $data['module'] = 'function';
            $data['action'] = 'ImgOssUpload';
            $data['dataname'] = "OSSUploadExpection";
            $data['data'] = $e->getMessage() ;
            addErrorLog($data['action'],$data['module'],$data['dataname'],$data['data']);
            return false;
          }   
} 

