<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class StatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:get 
                            {module : The name of the module whose stats you want to display} 
                            {arguments?* : Arguments do you want to pass to the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'display the statistics for specific module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arguments = $this->arguments();

        switch ($arguments['module']) {
            case 'items':
                $type = $arguments['arguments'][0] ?? '*';
                $this->info("The items" . ($type == "*" ? "" : (" " . $type . "")) . " statistic's:\n");
                $result = Item::statistics($type);
                foreach ($result as $key => $value) {
                    $this->info($key . " : " . $value);
                }
                break;
        }
        return 0;
    }
}
