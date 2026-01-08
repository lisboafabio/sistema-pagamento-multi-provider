# Sistema de Pagamentos Multi-Provider

### Instruções para rodar o projeto
Use o comando <kbd>docker-compose up -d</kbd> e após o docker subir seu container, voce precisa rodar os comandos <kbd>docker-compose exec app php artisan migrate</kbd> e <kbd>docker-compose exec app php artisan migrate --env=testing</kbd>

### Postman
Para facilitar o uso da api, voce pode acessar a collection do postman abaixo:<br> https://www.postman.com/restless-station-601349/workspace/public/collection/14683797-f5c51707-2480-4063-ba71-1d615d40bc80?action=share&creator=14683797

### Outras informações
A aplicação está usando a porta 8080
