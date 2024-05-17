<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            DB::connection()->getPdo();
            // Kết nối thành công, bạn có thể log hoặc làm gì đó ở đây
            Log::info('Database connection established');
            $this->commands([
                \Illuminate\Foundation\Console\UpCommand::class,
                \Illuminate\Foundation\Console\DownCommand::class,
            ]);
        } catch (\Exception $e) {
            // Kết nối thất bại, xử lý lỗi ở đây
            die("Could not connect to the database. Please check your configuration. error:" . $e );
        }
    }
}
