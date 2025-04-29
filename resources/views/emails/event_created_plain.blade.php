Um novo evento foi criado!

Título: {{ $event->title }}
Data: {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}
Local: {{ $event->location }}
Produtor: {{ $event->producer->company_name ?? 'Desconhecido' }}
Descrição: {{ $event->description ?? 'Sem descrição' }}
