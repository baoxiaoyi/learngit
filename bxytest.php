    <?php  
    /** 
      * wechat php test 
      */  
      
    //define your token  
    define("TOKEN", "bxy");  
    $wechatObj = new wechatCallbackapiTest();  
    $wechatObj->valid();  
    //$wechatObj->responseMsg();  
      
    class wechatCallbackapiTest  
    {   
    //���ﴦ����  
        public function responseMsg()  
        {  
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];  
            if (!empty($postStr)){  
                   libxml_disable_entity_loader(true);  
                    $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);  
                    $fromUsername = $postObj->FromUserName;  
                    $toUsername = $postObj->ToUserName;  
                    $keyword = trim($postObj->Content);  
                    $time = time();  
                    $textTpl = "<xml>  
                                <ToUserName><![CDATA[%s]]></ToUserName>  
                                <FromUserName><![CDATA[%s]]></FromUserName>  
                                <CreateTime>%s</CreateTime>  
                                <MsgType><![CDATA[%s]]></MsgType>  
                                <Content><![CDATA[%s]]></Content>  
                                <FuncFlag>0</FuncFlag>  
                                </xml>";               
    switch($keyword){  
    case "����":  
    $msgType = "text";  
    $contentStr="���ã����ƣ���֪���������˰���Ͱͣ�";  
    break;  
    case "����":  
    $msgType = "text";  
    $contentStr="���ã����ڣ���֪�����������۹���";  
    break;  
    case "ʷ����":  
    $msgType = "text";  
    $contentStr="���ã�ʷ��������֪���������˾������磡";  
    break;  
    default :  
    $msgType = "text";  
    $contentStr="����˭������һ������ȥ��";  
    break;  
    }  
    if(!empty($contentStr)){  
    //�����΢���ն�  
    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);  
    echo $resultStr;  
    }                 
                      
                      
      
            }else {  
                echo "";  
                exit;  
            }  
        }  
      
    //�ӿ���֤����  
    public function valid()  
        {  
            $echoStr = $_GET["echostr"];  
      
            //valid signature , option  
            if($this->checkSignature()){  
                echo $echoStr;  
                //exit;  
            }  
        }  
    private function checkSignature()  
        {  
            // you must define TOKEN by yourself  
            if (!defined("TOKEN")) {  
                throw new Exception('TOKEN is not defined!');  
            }  
              
            $signature = $_GET["signature"];  
            $timestamp = $_GET["timestamp"];  
            $nonce = $_GET["nonce"];  
                      
            $token = TOKEN;  
            $tmpArr = array($token, $timestamp, $nonce);  
            // use SORT_STRING rule  
            sort($tmpArr, SORT_STRING);  
            $tmpStr = implode( $tmpArr );  
            $tmpStr = sha1( $tmpStr );  
              
            if( $tmpStr == $signature ){  
                return true;  
            }else{  
                return false;  
            }  
        }  
    }  
      
    ?>  