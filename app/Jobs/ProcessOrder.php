<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Order;
use App\Notifications\OrderCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly Order $order,
        private readonly Customer $customer,
    ) {
    }

    public function handle(): void
    {
        try {
            Log::info('Notifying customer about shipped order', ['order_id' => $this->order->id]);
            $this->customer->notify(new OrderCreated($this->order));
            Log::info('Notification sent successfully', ['customer_id' => $this->customer->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send notification', [
                'order_id' => $this->order->id,
                'customer_id' => $this->customer->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
