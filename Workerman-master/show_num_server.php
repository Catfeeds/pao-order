<?php
use Workerman\Worker;
require_once './Autoloader.php';

global $uidConnectionMap;
$uidConnectionMap = array();
// ���ͻ���������ʱ����uid�����������ӣ���֪ͨ���пͻ���
function handle_connection($connection)
{
    //��������
}

// ���ͻ��˷�����Ϣ����ʱ
function handle_message($connection, $data)
{
    global $uidConnectionMap;
    // Ϊ������ӷ���һ��uid
    $connection->id = $data;
    $uidConnectionMap[$connection->id] = $connection;
}

// ���ͻ��˶Ͽ�ʱ��ɾ���Ͽ���$connection
function handle_close($connection)
{
    global $uidConnectionMap;
    unset($uidConnectionMap[$connection->id]);
}

function handle_workerStart(){
    // ����һ��http�˿�
    $inner_http_worker = new Worker('http://0.0.0.0:8129');
    // ��http�ͻ��˷�������ʱ����
    $inner_http_worker->onMessage = function($http_connection, $data){
//        file_put_contents(__DIR__."/"."sockLog.txt","data����".$data."\r\n",FILE_APPEND);
        global $uidConnectionMap;
        $_POST = $_POST ? $_POST : $_GET;
//        file_put_contents(__DIR__."/"."sockLog.txt","���ͣ�".$_POST['type']."\r\n",FILE_APPEND);
//        file_put_contents(__DIR__."/"."sockLog.txt","666\r\n",FILE_APPEND);
        // �������ݵ�url��ʽ type=send&to=uid&content=xxxx
        switch(@$_POST['type']){
            case 'send':
                global $text_worker;
                $to = @$_POST['to'];
                $_POST['content'] = htmlspecialchars(@$_POST['content']);
                // ��ָ��uid����uid����socket�鷢������
                if($to){
                    $conn = $uidConnectionMap[$to];
                    $conn->send(@$_POST['content']);
                    // ����������uid��������
                }else{
                    foreach($text_worker->connections as $conn)
                    {
                        $conn->send(@$_POST['content']);
//                        file_put_contents(__DIR__."/"."sockLog.txt","������uid��post���ݣ�".$_POST['content']."\r\n",FILE_APPEND);
                    }
                }
                // http�ӿڷ��أ�����û�����socket����fail
                // if($to && !isset($uidConnectionMap[$to])){
                //     return $http_connection->send('offline');
                // }else{
                //     return $http_connection->send("ok");
                // }
        }
        return $http_connection->send('fail');
    };
    // ִ�м���
    $inner_http_worker->listen();
}

// ����һ���ı�Э���Worker����2347�ӿ�
$text_worker = new Worker("websocket://0.0.0.0:9218");

// ֻ����1�����̣���������ͻ���֮�䴫������
$text_worker->count = 1;

$text_worker->onWorkerStart = 'handle_workerStart';
$text_worker->onConnect = 'handle_connection';
$text_worker->onMessage = 'handle_message';
$text_worker->onClose = 'handle_close';
$text_worker->listen();

Worker::runAll();