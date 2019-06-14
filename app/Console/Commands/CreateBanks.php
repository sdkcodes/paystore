<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Sdkcodes\LaraPaystack\PaystackService;

class CreateBanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'naijabanks:create {--action=create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Nigerian banks as returned by paystack and save to database';

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
    public function handle(PaystackService $paystack)
    {
        $action = $this->option('action');
        try{
            $banks = $paystack->listBanks()->data;    
        }catch(\Throwable $e){
            $this->error("Unable to connect to paystack at this time");
            exit();
        }
        if (empty($banks)){
            $this->line("Couldn't get banks");
            return;
        }

        if ($action == "create"){
            if (Schema::hasTable('banks')){
                foreach ($banks as $bank){
                    DB::table('banks')->insert([
                        'name' => $bank->name,
                        'slug' => $bank->slug,
                        'code' => $bank->code,
                        'longcode' => $bank->longcode,
                        'active' => $bank->active
                    ]);
                    $this->line($bank->name . " added");
                }     
            }
        }
        else{
            
            if ($this->confirm("This action will delete all existing banks and recreate them. Are you sure you want to continue?")){
                Schema::dropIfExists('banks');

                Schema::create('banks', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('name');
                    $table->string('slug');
                    $table->string('code');
                    $table->string('longcode')->nullable();
                    $table->boolean('active')->default(true);
                    $table->timestamps();
                });

                foreach ($banks as $bank){
                    DB::table('banks')->insert([
                        'name' => $bank->name,
                        'slug' => $bank->slug,
                        'code' => $bank->code,
                        'longcode' => $bank->longcode,
                        'active' => $bank->active
                    ]);
                    $this->line($bank->name . " added");
                }    
            }
            
        }
    }
}
