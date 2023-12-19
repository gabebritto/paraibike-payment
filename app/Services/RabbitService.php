<?php

namespace App\Services;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitService
{
    /**
     * @throws Exception
     */
    public function publish($message): void
    {
        $connection = new AMQPStreamConnection(config('services.rabbit.host'), config('services.rabbit.port'), config('services.rabbit.user'), config('services.rabbit.password'));
        $channel = $connection->channel();
        $channel->exchange_declare('test_exchange', 'direct', false, false, false);
        $channel->queue_declare('payments', false, false, false, false);
        $channel->queue_bind('payments', 'test_exchange', 'test_key');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'test_exchange', 'test_key');
        echo " [x] Sent $message to test_exchange / test_queue.\n";
        $channel->close();
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public function consume(): void
    {
        $connection = new AMQPStreamConnection(config('services.rabbit.host'), config('services.rabbit.port'), config('services.rabbit.user'), config('services.rabbit.password'));
        $channel = $connection->channel();
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };
        $channel->queue_declare('payments', false, false, false, false);
        $channel->basic_consume('payments', '', false, true, false, false, $callback);
        echo 'Waiting for new message on payments', " \n";
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}
