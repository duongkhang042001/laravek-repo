<?php

namespace Database\Seeders;

use App\Models\MT\Message;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Database\Seeder;

class MTMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalRows = 1000000;
        $batchSize = 1000;
        $remainingRows = $totalRows;

        // Create a new instance of ProgressBar
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output);

        // Start the progress bar
        $progressBar->start($totalRows);

        while ($remainingRows > 0) {
            $rowsToCreate = min($batchSize, $remainingRows);

            Message::factory()->count($rowsToCreate)->create();

            // Update the progress bar
            $progressBar->advance($rowsToCreate);

            $remainingRows -= $rowsToCreate;
        }

        // Finish the progress bar
        $progressBar->finish();
    }
}
