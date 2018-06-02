<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Log;
use Symfony\Component\Console\Helper\ProgressBar;

class clear extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear '
                           . '{--m|migrate : Refresh migrations '
                           . '(run php artisan migrate:refresh -h for more)} '
                           . '{--s|seed : Re-seed the database '
                           . '(run php artisan db:seed -h for more)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears all cache files and logs from application';

    /**
     * Progress bar
     * @var ProgressBar
     */
    //private $bar;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
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
        $procs = '6';

        // Get migrate option //
        $migration = $this->option('migrate');

        $seed = $this->option('seed');

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

        // Init the progress bar //
        $bar = $this->output->createProgressBar($procs);

        $this->comment('Start Clearing Files:');

        // Logs //
        $this->logs($bar);

        // Compiled //
        $this->compiled($bar);

        // Cache //
        $this->cache($bar);

        // Configs //
        $this->configs($bar);

        // Routes //
        $this->routes($bar);

        // Images //
        $this->images($bar);

        // Run migrations //
        if ($migration) {
            $this->migrations($bar);
        }

        // Re-seed db //
        if ($seed) {
            $this->seed($bar);
        }

        $this->comment('Total Progress');

        $bar->finish();

        $this->comment("\nFinished Clearing Files.");
    }

    /**
     * Cleans the log files
     * @param ProgressBar $bar
     * @return bool
     */
    private function logs(ProgressBar $bar) {
        $this->line('Logs:');

        // Get all log files //
        $logs = glob(storage_path('logs/*.log'));

        // Loop through and remove //
        foreach ($logs as $log) {
            unlink($log);
        }
        $this->info('Log files have been cleared!');

        $bar->advance();

        $this->info('');

        return true;
    }

    /**
     * Clears compiled files
     * @param ProgressBar $bar
     * @return bool
     */
    private function compiled(ProgressBar $bar) {
        $this->line('Compiled Services:');
        $this->call('clear-compiled');

        $bar->advance();

        $this->info('');

        return true;
    }

    /**
     * Clears cache files
     * @param ProgressBar $bar
     * @return bool
     */
    private function cache(ProgressBar $bar) {
        $this->line('Cache:');
        $this->call('cache:clear');

        $bar->advance();

        $this->info('');

        return true;
    }

    /**
     * Clears config cache
     * @param ProgressBar $bar
     * @return bool
     */
    private function configs(ProgressBar $bar) {
        $this->line('Config:');
        $this->call('config:clear');

        $bar->advance();

        $this->info('');

        return true;
    }

    /**
     * Clears the route cache
     * @param ProgressBar $bar
     * @return bool
     */
    private function routes(ProgressBar $bar) {
        $this->line('Routes:');
        $this->call('route:clear');

        $bar->advance();

        $this->info('');

        return true;
    }

    /**
     * Deletes image files
     * @param ProgressBar $bar
     * @return bool
     */
    private function images(ProgressBar $bar) {
        // Logs //
        $this->line('Images:');

        $storage = Storage::disk('public_upload');

        $storage->deleteDirectory('main');
        // Avatars //

        $this->info('Image files successfully cleared!');

        $bar->advance();

        $this->info('');

        return true;
    }

    /**
     * Refreshes and calls the status on migrations
     * @param ProgressBar $bar
     * @return bool
     */
    private function migrations(ProgressBar $bar) {
        $this->line('Migrations refreshing:');
        $this->call('migrate:refresh');

        $this->info('Migration refresh complete.');

        $this->line('Migrations status:');

        $this->call('migrate:status');

        $bar->advance();

        $this->info('');

        return true;
    }

    /**
     * Re-seeds the database with mock data
     * @param ProgressBar $bar
     * @return bool
     */
    private function seed(ProgressBar $bar) {
        $this->line('Re-seeding database:');
        $this->call('db:seed');

        $bar->advance();

        $this->info('');

        return true;
    }
}
