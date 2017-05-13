<?php
use Workerman\Worker;
require_once './Autoloader.php';

global $uidConnectionMap;
$uidConnectionMap = array();
// 当客户端连上来时分配uid，并保存连接，并通知所有客户端
function handle_connection($connection)
{
    //不做处理
}

// 当客户端发送消息过来时
function handle_message($connection, $data)
{
    global $uidConnectionMap;
    // 为这个链接分配一个uid
    $connection->id = $data;
    $uidConnectionMap[$connection->id] = $connection;
}

// 当客户端断开时，删除断开的$connection
function handle_close($connection)
{
    global $uidConnectionMap;
    unset($uidConnectionMap[$connection->id]);
}

function handle_workerStart(){
    // 监听一个http端口
    $inner_http_worker = new Worker('http://0.0.0.0:8129');
    // 当http客户端发来数据时触发
    $inner_http_worker->onMessage = function($http_connection, $data){
//        file_put_contents(__DIR__."/"."sockLog.txt","data内容".$data."\r\n",FILE_APPEND);
        global $uidConnectionMap;
        $_POST = $_POST ? $_POST : $_GET;
//        file_put_contents(__DIR__."/"."sockLog.txt","类型：".$_POST['type']."\r\n",FILE_APPEND);
//        file_put_contents(__DIR__."/"."sockLog.txt","666\r\n",FILE_APPEND);
        // 推送数据的url格式 type=send&to=uid&content=xxxx
        switch(@$_POST['type']){
            case 'send':
                global $text_worker;
                $to = @$_POST['to'];
                $_POST['content'] = htmlspecialchars(@$_POST['content']);
                // 有指定uid则向uid所在socket组发送数据
                if($to){
                    $conn = $uidConnectionMap[$to];
                    $conn->send(@$_POST['content']);
                    // 否则向所有uid推送数据
                }else{
                    foreach($text_worker->connections as $conn)
                    {
                        $conn->send(@$_POST['content']);
//                        file_put_contents(__DIR__."/"."sockLog.txt","向所有uid，post内容：".$_POST['content']."\r\n",FILE_APPEND);
                    }
                }
                // http接口返回，如果用户离线socket返回fail
                // if($to && !isset($uidConnectionMap[$to])){
                //     return $http_connection->send('offline');
                // }else{
                //     return $http_connection->send("ok");
                // }
        }
        return $http_connection->send('fail');
    };
    // 执行监听
    $inner_http_worker->listen();
}

// 创建一个文本协议的Worker监听2347接口
$text_worker = new Worker("websocket://0.0.0.0:9218");

// 只启动1个进程，这样方便客户端之间传输数据
$text_worker->count = 1;

$text_worker->onWorkerStart = 'handle_workerStart';
$text_worker->onConnect = 'handle_connection';
$text_worker->onMessage = 'handle_message';
$text_worker->onClose = 'handle_close';
$text_worker->listen();

Worker::runAll();