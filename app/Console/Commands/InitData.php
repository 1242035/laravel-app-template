<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use DB;

class InitData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init example data';

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

        try {

            $examples = Storage::disk('local')->get('public/data/csv_example.csv');
            
            $this->info("Read csv file is successfully");
            $array = $this->generateDataArray("examples", $examples);
            
            DB::beginTransaction();
            
            if (!DB::table('examples')->get()->count()) {
                DB::table('examples')->insert($array);
            }
            
            DB::commit();
            $this->info("Insert to BD is successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Insert to BD is Failure");
            $this->error($e->getMessage());
        }
    }

    //Generate array data from content csv
    private function generateDataArray(string $table_name, string $content_data, $end = "\n")
    {
        $content_data = preg_replace('/\d/', '', $content_data);
        $content_array = explode($end, $content_data);
        unset($content_array[0]);
        $res = [];
        foreach ($content_array as $index => $data) {
            $data = explode(",", $data);
            if ($table_name == "example" && isset($data[1]) && isset($data[2])) {
                $data_array_item['code'] = $data[2];
                $data_array_item['name'] = $data[1];
                $res[] = $data_array_item;
            }
        }
        $content_array = $res;
        return $content_array;
    }
}
