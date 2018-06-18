<?php

/**
 * An artisan command to help users set up application for it's first run.
 * User's can select to do a bare-bones install, or a full on install of database and mock data
 *
 * @author Casper Wilkes <casper@capserwilkes.net>
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class setupCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup '
                           . '{--s|seed : Seed the database (users|comments|images)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up the application for the first time: Should only need to be run once. '
                             . 'Generates: App key|Image directory|Migrations(|Seeds)';

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
        $procs = '4';

        $seed = $this->option('seed');

        // Seed option called //
        if ($seed) {
            // Up the procs //
            $procs++;
        }

        // Init the progress bar //
        $bar = $this->output->createProgressBar($procs);

        // Start output //
        $this->comment("Starting initial setup of application:\n");

        // Generate Key //
        $this->genKey($bar);

        // Generate img directory //
        $this->genImg($bar);

        // Gen config cache //
        $this->genCache($bar);

        // Generate migrations //
        $this->genMigrate($bar);

        // Seed db //
        if ($seed) {
            $this->genSeeds($bar);
        }

        // Finish up //
        $this->comment("\nTotal Progress");

        $bar->finish();
        $this->line('');

        // Get finish time execution //
        $finish = round(microtime(true) - $this->start_time, 2);
        $this->comment("Total execution time: {$finish} seconds\n");

        $this->comment('Finished initial setup of application.');
    }

    /**
     * Generate app key
     * @param ProgressBar $bar
     */
    private function genKey(ProgressBar $bar) {
        $this->line('Generating app key:');

        $this->call('key:generate');

        $bar->advance();
        $this->line('');

        $this->info('Finished generating app key.');
    }

    /**
     * Generate img directory
     * @param ProgressBar $bar
     */
    private function genImg(ProgressBar $bar) {
        // Create img dir //
        $this->line('Generating `public/img` directory:');

        build_img_structure();

        $bar->advance();
        $this->line('');

        $this->info('Finished generating img directory.');
    }

    /**
     * Generate migrations
     * @param ProgressBar $bar
     */
    private function genMigrate(ProgressBar $bar) {
        // Run migrations //
        $this->line('Generating Migrations:');

        $this->call('migrate');
        $this->info('Migrations complete.');

        $this->line('Migrations status:');
        $this->call('migrate:status');

        $bar->advance();
        $this->line('');

        $this->info('Finished generating migrations.');
    }

    /**
     * Generates cache files
     * @param ProgressBar $bar
     */
    private function genCache(ProgressBar $bar) {
        $this->line('Generating cache files:');

        $this->comment('Config:');
        $this->call('config:cache');
        $this->info('Finished config cache.');

        $this->comment('Route:');
        $this->call('route:cache');
        $this->info('Finished route cache.');

        $bar->advance();
        $this->line('');

        $this->info('Finished generating cache files');
    }

    /**
     * Generate seeds
     * @param ProgressBar $bar
     */
    private function genSeeds(ProgressBar $bar) {
        $this->line('Generating seeds for database:');
        $this->info('This will take a few moments.');
        $this->call('db:seed');

        $bar->advance();
        $this->line('');

        $this->info('Finished generating seeds');
    }
}
