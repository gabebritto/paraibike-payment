<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\CheckoutCreatedNotification;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Stripe\Stripe;

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
            $decoded = json_decode($msg->body);
            echo ' [x] Received ', $decoded->user->email, "\n";

            $user = User::where('email', $decoded->user->email)->first();

            if ($user) {
                echo ' [ ] Processing checkout', "\n";
                $user->createOrGetStripeCustomer();
                $checkout = $user->checkout([config('services.stripe.credit') => (int) $decoded->value], ['success_url' => route('success', ['key' => "/4dfs_".(int) $decoded->value."_".$user->stripeId()])])->toArray();

                $user->notify(new CheckoutCreatedNotification(['url' => $checkout['url'], 'name' => $user->name, 'credits' => (int) $decoded->value]));
                echo ' [x] Checkout processed and sent to email', "\n";
            }
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
