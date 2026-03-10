<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakePayloadRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:payload {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建 POST 请求类';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('make:data', ['name' => 'Requests/Payloads/' . $this->argument('name')]);
    }
}
