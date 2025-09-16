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
├── admin_veiculos.php      # Painel admin para cadastro de veículos
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
     ```

3. **Imagens:**
   - Adicione as imagens dos veículos na pasta `img/` com os nomes indicados.

## Funcionalidades
- Cadastro de usuário (apenas usuários comuns pelo site)
- Login com autenticação JWT
- Edição de dados e alteração de senha
- Listagem de veículos disponíveis (apenas os cadastrados pelo admin)
- Locação de veículos (registro e bloqueio de disponibilidade)
- Visualização de locações no perfil
- Logout
- Painel administrativo para cadastro de veículos (apenas para administradores)
- Controle de usuários administradores (apenas admin pode promover outro usuário a admin, via painel restrito ou diretamente no banco)
- Design responsivo e moderno
- Formulários centralizados, campos em coluna e espaçamento entre campos

## Controle de Administradores

- Usuários comuns não podem se cadastrar como administradores.
- Para permitir administradores, adicione o campo `is_admin` na tabela `usuarios`:
  ```sql
  ALTER TABLE usuarios ADD COLUMN is_admin BOOLEAN DEFAULT FALSE;
  ```
- Para promover um usuário a administrador, execute:
  ```sql
  UPDATE usuarios SET is_admin = TRUE WHERE email = 'email_do_admin@dominio.com';
  ```
- Apenas administradores acessam o painel `admin_veiculos.php` para cadastrar novos veículos.
- O botão "Adicionar Veículo" aparece no menu apenas para administradores logados.


## Demonstração
1. Acesse `http://localhost/aluga++/` no navegador.
2. Cadastre-se, faça login e utilize todas as funcionalidades.
3. Para acessar o painel admin, faça login como administrador e clique em "Adicionar Veículo".

---
