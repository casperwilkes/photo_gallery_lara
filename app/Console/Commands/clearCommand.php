<?php

/**
 * An artisan command to help users clear the application while developing
 * Users have various options, but mainly to clear out images/configs/database migrations.
 *
 * @author Casper Wilkes <casper@capserwilkes.net>
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Log;
use Symfony\Component\Console\Helper\ProgressBar;

class clearCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear '
                           . '{--s|seed : Re-seed the database '
                           . '(run php artisan db:seed -h for more)}'
                           . '{--i|image : Dump image directories} '
                           . '{--g|generate : Generate caches '
                           . '(Route|Config)}'
                           . '{--m|migrate : Refresh migrations '
                           . '(run php artisan migrate:refresh -h for more)} '
                           . '{--a|all : Run all options}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Completely refreshes the application(logs|migrations|seeds|images|caches)';

    /**
     * start time of execution
     * @var string
     */
    private $start_time = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        // Start timer //
        $this->start_time = microtime(true);

        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        // Initial procs for bar //
        // One for every task //
        $procs = '2';

        // Get migrate option //
        $migration = $this->option('migrate');

        $seed = $this->option('seed');

        $image = $this->option('image');

        $gen = $this->option('generate');

        $all = $this->option('all');

        // Run all options //
        if ($all) {
            $seed = $image = $gen = $migration = true;
        }

        // Migrate option called //
        if ($migration) {
            // Up the procs //
            $procs++;
        }

        // Seed option called //
        if ($seed) {
            // Up the procs //
            $procs++;
        }

        // Image options //
        if ($image) {
            // Up the procs //
            $procs++;
        }

        // Regenerate caches
        if ($gen) {
            $procs++;
        }

        // Init the progress bar //
        $bar = $this->output->createProgressBar($procs);

        $this->comment("Start Clearing Files:\n");

        // Logs //
        $this->logs($bar);

        // Cache //
        $this->cache($bar);

        // Images //
        if ($image) {
            $this->images($bar);
        }

        // Run migrations //
        if ($migration) {
            $this->migrations($bar);
        }

        // Re-seed db //
        if ($seed) {
            $this->seed($bar);
        }

        // Re-generate configs //
        if ($gen) {
            $this->genCache($bar);
        }

        $this->comment("\nTotal Progress");

        $bar->finish();
        $this->line('');

        // Get finish time execution //
        $finish = round(microtime(true) - $this->start_time, 2);
        $this->comment("Total execution time: {$finish} seconds\n");

        $this->comment('Finished Clearing Files.');
    }

    /**
     * Clears the log files
     * @param ProgressBar $bar
     */
    private function logs(ProgressBar $bar) {
        $this->line('Clearing Log files:');

        // Get all log files //
        $logs = glob(storage_path('logs/*.log'));

        // Loop through and remove //
        foreach ($logs as $log) {
            unlink($log);
        }

        $bar->advance();
        $this->line('');

        $this->info('Finished clearing logs.');
    }

    /**
     * Clears cache files
     * @param ProgressBar $bar
     */
    private function cache(ProgressBar $bar) {
        $this->line('Clearing caches:');
        $this->comment('Cache:');
        $this->call('cache:clear');
        $this->comment('Config:');
        $this->call('config:clear');
        $this->comment('Compiled:');
        $this->call('clear-compiled');
        $this->comment('Route:');
        $this->call('route:clear');
        $this->comment('Views:');
        $this->call('view:clear');

        $bar->advance();
        $this->line('');

        $this->info('Finished clearing caches');
    }

    /**
     * Deletes image files
     * @param ProgressBar $bar
     */
    private function images(ProgressBar $bar) {
        // Logs //
        $this->line('Clearing images:');

        $storage = Storage::disk('public_upload');

        // Main //
        $storage->deleteDirectory('main');

        // Avatars //
        $storage->deleteDirectory('avatar');

        $bar->advance();
        $this->line('');

        $this->info('Finished clearing images.');
    }

    /**
     * Refreshes and calls the status on migrations
     * @param ProgressBar $bar
     */
    private function migrations(ProgressBar $bar) {
        $this->line('Clearing migrations:');
        $this->comment('Dropping:');
        $this->call('migrate:reset');
        $this->comment('Running');
        $this->call('migrate');
        $this->comment('Status:');
        $this->call('migrate:status');

        $bar->advance();
        $this->line('');

        $this->info('Finished running migrations.');
    }

    /**
     * Re-seeds the database with mock data
     * @param ProgressBar $bar
     */
    private function seed(ProgressBar $bar) {
        $this->line('Re-seeding database:');
        $this->info('This will take a few moments.');
        $this->call('db:seed');

        $bar->advance();
        $this->line('');

        $this->info('Finished re-seeding database.');
    }

    /**
     * Creates config cache
     * @param ProgressBar $bar
     */
    private function genCache(ProgressBar $bar) {
        $this->line('Re-Generating cache files:');

        $this->comment('Config:');
        $this->call('config:cache');
        $this->info('Finished config cache.');

        $this->comment('Route:');
        $this->call('route:cache');
        $this->info('Finished route cache.');

        $bar->advance();
        $this->line('');

        $this->info('Finished re-generating cache files');
    }
}
