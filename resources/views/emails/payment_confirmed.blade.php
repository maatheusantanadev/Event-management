
<h1>Pagamento Confirmado</h1>
<p>O pagamento foi confirmado com sucesso.</p>
<ul>
    <li><strong>ID da Transação:</strong> {{ $payment->transaction_id }}</li>
    <li><strong>Valor:</strong> R$ {{ number_format($payment->amount, 2, ',', '.') }}</li>
    <li><strong>Status:</strong> {{ ucfirst($payment->status) }}</li>
</ul>