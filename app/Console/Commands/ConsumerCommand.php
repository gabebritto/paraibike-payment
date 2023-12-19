<?php

namespace App\Console\Commands;

use App\Services\RabbitService;
use Exception;
use Illuminate\Console\Command;

class ConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbit:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Opens listener to payments queue in rabbitmq';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $consumer = new RabbitService();
        $consumer->consume();
    }
}
