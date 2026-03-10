<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeQueryRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:query {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建 Query 请求类';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('make:data', ['name' => 'Requests/Queries/' . $this->argument('name')]);
    }
}
