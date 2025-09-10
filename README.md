# Aluga++ - Sistema de Gestão de Locação de Veículos

## Descrição
Aplicação web desenvolvida em PHP, MySQL, HTML, CSS e JavaScript para gestão de locação de veículos (carros e motos). Permite cadastro, login, locação, visualização de veículos e locações, edição de dados e alteração de senha, com autenticação JWT e design moderno responsivo.

## Estrutura de Pastas
```
aluga++/
├── css/
│   └── style.css
├── db/
│   ├── db.php
│   ├── alugapp_completo.sql
│   └── tabelas.sql
├── img/
│   ├── honda-cg160.jpg
│   ├── fiat-uno.jpg
│   ├── yamaha-fazer.jpg
│   └── vw-gol.jpg
├── js/
│   └── main.js
├── vendor/
│   └── (biblioteca JWT via Composer)
├── index.php
├── login.php
├── register.php
├── profile.php
├── edit_user.php
├── change_password.php
├── rent.php
├── logout.php
```

## Instalação
1. **Banco de dados:**
   - Importe o arquivo `db/alugapp_completo.sql` no MySQL (phpMyAdmin ou terminal).
   - Isso criará o banco `alugapp`, tabelas e veículos de demonstração.

2. **Dependências PHP:**
   - Instale o Composer: https://getcomposer.org/download/
   - No terminal, execute:
     ```
     composer require firebase/php-jwt
     ```
   - Isso criará a pasta `vendor` e o arquivo `vendor/autoload.php`.

3. **Configuração do banco:**
   - O arquivo de conexão está em `db/db.php`.
   - Ajuste usuário/senha se necessário:
     ```php
     $host = 'localhost';
     $user = 'root';
     $pass = '';
     $db = 'alugapp';
     ```

4. **Imagens:**
   - Adicione as imagens dos veículos na pasta `img/` com os nomes indicados.

## Funcionalidades
- Cadastro de usuário
- Login com autenticação JWT
- Edição de dados e alteração de senha
- Listagem de veículos disponíveis
- Locação de veículos (registro e bloqueio de disponibilidade)
- Visualização de locações no perfil
- Logout
- Design responsivo e moderno

## Observações
- O sistema utiliza sessões PHP e tokens JWT para autenticação.
- As senhas são criptografadas no banco.
- O frontend é mobile-first, com gradientes, sombras e animações suaves.

## Demonstração
1. Acesse `http://localhost/aluga++/` no navegador.
2. Cadastre-se, faça login e utilize todas as funcionalidades.

---
