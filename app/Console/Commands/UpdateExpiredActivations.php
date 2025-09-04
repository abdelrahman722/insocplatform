<?php

namespace App\Console\Commands;

use App\Models\Activation;
use App\Models\School;
use Illuminate\Console\Command;

class UpdateExpiredActivations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activations:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $count = School::where('is_active', true)
            ->whereDate('subscription_end', '<=', $now)
            ->update(['is_active' => false]);
        $this->info("updated $count recourds");
    }
}
