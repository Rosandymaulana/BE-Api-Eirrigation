<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-api-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generated random API key';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prefix = 'eikb';
        $rand1 = substr(md5(uniqid()), 0, 8);
        $rand2 = Str::random(8);
        $rand3 = strval(mt_rand(1000, 9999));
        $rand4 = str_shuffle(Str::random(4));
        $rand5 = Str::random(10);

        $apiKey = "$prefix-$rand1-$rand2-$rand3-$rand4-$rand5";

        $this->info('API Key: ' . $apiKey);
    }
}
