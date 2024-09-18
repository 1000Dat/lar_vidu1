<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // Ví dụ: Lên lịch cho lệnh 'inspire' chạy mỗi giờ
        // $schedule->command('inspire')->hourly();

        // Thêm các lệnh khác để chạy định kỳ
        // Ví dụ: Lên lịch cho lệnh 'emails:send' chạy hàng ngày lúc 1 giờ sáng
        // $schedule->command('emails:send')->dailyAt('01:00');
        
        // Ví dụ: Lên lịch cho một lệnh tùy chỉnh
        // $schedule->call(function () {
        //     // Tác vụ tùy chỉnh
        // })->weekly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        // Tải các lệnh console từ thư mục /app/Console/Commands
        $this->load(__DIR__.'/Commands');

        // Yêu cầu file console.php từ thư mục routes để đăng ký các lệnh console thêm nếu cần
        require base_path('routes/console.php');
    }
    protected $routeMiddleware = [
        // Other middlewares
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
    
}
