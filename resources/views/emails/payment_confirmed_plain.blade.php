Pagamento Confirmado

ID da Transação: {{ $payment->transaction_id }}
Valor: R$ {{ number_format($payment->amount, 2, ',', '.') }}
Status: {{ ucfirst($payment->status) }}