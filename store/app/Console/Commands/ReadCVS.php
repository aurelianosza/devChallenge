<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Csv;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoadCVSResponse;

class ReadCVS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Cv\'s files uploaded. ';

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
     * @return mixed
     */
    public function handle()
    {
        foreach(Csv::all() as $file){
            
            $products = Storage::disk('local')->get($file->file);

            $num = Product::loadCVS($products);

            Storage::disk('local')->delete($file->file);
            
            $file->delete();
            
            Mail::to(User::find($file->user_id)->email)->send(new LoadCVSResponse($num));
            
        }
    }
}
