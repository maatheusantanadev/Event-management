<h1>Um novo evento foi criado!</h1>

<p><strong>Título:</strong> {{ $event->title }}</p>
<p><strong>Data:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}</p>
<p><strong>Local:</strong> {{ $event->location }}</p>
<p><strong>Produtor:</strong> {{ $event->producer->company_name ?? 'Desconhecido' }}</p>
<p><strong>Descrição:</strong> {{ $event->description ?? 'Sem descrição' }}</p>