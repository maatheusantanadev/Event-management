<?php

namespace Tests\Feature\Job;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\ProcessPaymentJob;
use App\Models\Payment;
use App\Models\User;
use App\Models\Ticket;
use App\Services\PagguePaymentService;
use App\Mail\PaymentEmail;
use Mockery;
use Spatie\Permission\Models\Role;

class ProcessPaymentJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_does_not_process_if_payment_is_not_pending()
    {
        $payment = Payment::factory()->create([
            'status' => 'confirmado'
        ]);

        $mock = Mockery::mock(PagguePaymentService::class);
        $mock->shouldNotReceive('gerarPagamento');
        $this->app->instance(PagguePaymentService::class, $mock);

        ProcessPaymentJob::dispatchSync($payment->id);

        $this->assertDatabaseMissing('payments', [
            'id' => $payment->id,
            'status' => 'falha',
        ]);
    }

    public function test_job_sets_status_to_falha_on_error_response()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create(['user_id' => $user->id]);

        $payment = Payment::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'status' => 'pendente',
            'amount' => 200,
            'transaction_id' => 'fail-uuid',
        ]);

        $mock = Mockery::mock(PagguePaymentService::class);
        $mock->shouldReceive('gerarPagamento')->once()->andReturn([]);
        $this->app->instance(PagguePaymentService::class, $mock);

        ProcessPaymentJob::dispatchSync($payment->id);

        $payment->refresh();
        $this->assertEquals('falha', $payment->status);
    }
}