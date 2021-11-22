<?php 
use Workerman\Worker;

require_once __DIR__ . '/../vendor/autoload.php';

$wsWorker = new Worker('websocket://0.0.0.0:2346');

// Количество подключаемых клиентов
$wsWorker->count = 4;

// Создаем колбек для обработки подключения
$wsWorker->onConnect = function ($connect) {
	echo "New connection \n";
};

$wsWorker->onMessage = function ($connect, $data) use ($wsWorker) {
	foreach($wsWorker->connections as $clientConnection) {
		$clientConnection->send($data);
	}
};

// Создаем колбек для обработки отключения
$wsWorker->onClose = function ($connect) {
	echo "Connection closed \n";
};

Worker::runAll();