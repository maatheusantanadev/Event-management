<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">Sistema de Gestão de Eventos</h1>

<p align="center">
  API desenvolvida em Laravel para gestão de eventos, pagamentos, usuários e permissões.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-red.svg" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.x-blue.svg" alt="PHP">
  <img src="https://img.shields.io/badge/license-MIT-green.svg" alt="License">
</p>

---

## ✨ Funcionalidades

- Cadastro e autenticação de usuários
- Controle de permissões (admin, produtor de eventos, cliente)
- Criação e gerenciamento de produtores/eventos/setores/lots/tickets/pagamentos/coupons
- Envio de e-mails com Mailable
- Notificações para administradores
- Testes automatizados (com PHPUnit)

---

## 🚀 Tecnologias Utilizadas

- [Laravel 10](https://laravel.com/)
- [PHP 8.x](https://www.php.net/)
- [MySQL/PostgreSQL](https://www.mysql.com/)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/)
- [Paggue API](https://paggue.io)
- [JWT Auth](https://jwt.io/) para autenticação

---

## ⚙️ Instalação

```bash
# Clone o repositório
git clone https://github.com/maatheusantanadev/Event-management
cd Event-management
# Instale as dependências
composer install

# Copie o arquivo de ambiente e configure
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Configure seu banco de dados no .env e rode as migrations
php artisan migrate --seed

# Rode o servidor local
php artisan serve
```

## 🧾 Documentação
``` bash
Para vizualizar documentação:
        # Rode o servidor local
        php artisan serve
        # Rode em seu navegador
        http://127.0.0.1:8000/docs
Colletion Postman:
        docs\postman\Event Management API.postman_collection.json
```

## 🔐 Autenticação 
``` bash
A autenticação é feita via JWT. Após realizar login, utilize o token gerado no cabeçalho de cada requisição protegida:

Authorization: Bearer SEU_TOKEN_JWT
```

## 🧪 Rodando Testes
``` bash
php artisan test

Para ver a cobertura dos testes com PHPUnit:
./vendor/bin/phpunit --coverage-html coverage/
ou abrir arquivo index na pasta coverage-report\index.html
```

## 📤 Envio de E-mails
``` bash
O sistema envia e-mails para administradores automaticamente nas seguintes situações:

Criação de novo evento

Você pode configurar o serviço de e-mail no .env, por exemplo:

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=suaconta@gmail.com
MAIL_PASSWORD=suasenha123
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@gmail.com"
MAIL_FROM_NAME="Sistema de Eventos"
```


## 👥 Perfis de Usuário
``` bash
Admin: Acesso total ao sistema.
Produtor de Eventos: Cria e edita eventos/lots/setores.
Cliente: Compra e vizualiza ingressos.
```

## 🧾 Licença
Este projeto está licenciado sob os termos da licença MIT.

## 👨‍💻 Autor
``` bash
Desenvolvido por Matheus Santana
Entre em contato: mssantana@ecomp.uefs.br
```
