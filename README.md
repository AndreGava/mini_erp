<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Mini ERP para Controle de Pedidos

Este projeto é uma solução de Mini ERP desenvolvida como parte de um teste técnico. O sistema permite o gerenciamento de Produtos, Pedidos, Cupons e Estoque, utilizando Laravel para o backend.

<!-- Você pode manter os badges do Laravel se quiser, ou remover/substituir por badges do seu próprio repositório quando ele estiver no GitHub -->
<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Funcionalidades Principais

*   Cadastro e atualização de Produtos (com nome, preço, variações).
*   Controle de Estoque associado aos produtos e suas variações.
*   Sistema de Carrinho de Compras gerenciado por sessão.
*   Cálculo de Frete dinâmico baseado no subtotal do pedido.
*   Verificação de CEP utilizando a API ViaCEP.
*   Gerenciamento de Cupons de Desconto (com validade e valor mínimo).
*   Finalização de Pedidos com envio de e-mail de confirmação.
*   Webhook para atualização de status de pedidos.

## Tecnologias Utilizadas

*   **Backend:** PHP 8.2 (ou superior, conforme `composer.json`), Laravel 11.x
*   **Banco de Dados:** MySQL
*   **Frontend (sugerido/compatível):** Bootstrap, HTML, CSS, JavaScript
*   **Gerenciamento de Dependências:** Composer (PHP), NPM (JavaScript)

## Pré-requisitos

*   PHP >= 8.2 (verifique a versão exata do seu projeto no `composer.json`)
*   Composer
*   Node.js e NPM
*   Servidor MySQL
*   Um servidor web como Apache ou Nginx (para produção), ou use `php artisan serve` para desenvolvimento.

## Instruções de Instalação e Configuração

Siga os passos abaixo para configurar o ambiente de desenvolvimento:

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/AndreGava/mini_erp.git
    cd mini_erp
    ```

2.  **Instale as dependências do Composer:**
    ```bash
    composer install
    ```

3.  **Copie o arquivo de ambiente e configure suas variáveis:**
    ```bash
    cp .env.example .env
    ```
    Abra o arquivo `.env` e configure as variáveis do banco de dados (`DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_DATABASE=mini_erp`, `DB_USERNAME=root`, `DB_PASSWORD=SUA_SENHA_DO_MYSQL_AQUI`) e outras que precisar (como `MAIL_MAILER`, `MAIL_HOST`, etc., para envio de e-mail).

4.  **Gere a chave da aplicação Laravel:**
    ```bash
    php artisan key:generate
    ```

5.  **Execute as Migrations (e Seeders, se houver dados iniciais):**
    Para criar a estrutura do banco de dados:
    ```bash
    php artisan migrate
    ```
    Se você tiver seeders para popular o banco com dados iniciais/de teste (o projeto possui factories que podem ser usadas via seeders):
    ```bash
    php artisan db:seed
    ```

    **Alternativa (Dump SQL):** Se você preferir usar um arquivo de dump SQL para criar a estrutura e/ou popular o banco (um arquivo `database_dump_estrutura.sql` ou `database_dump_com_dados.sql` pode estar incluído no repositório):
    ```bash
    # Exemplo de como importar um dump SQL (o comando pode variar)
    # mysql -u root -p mini_erp < nome_do_arquivo_dump.sql
    ```
    *Nota: Recomenda-se usar as migrations como método principal.*

6.  **Instale as dependências do NPM e compile os assets (se aplicável para o frontend):**
    ```bash
    npm install
    npm run dev 
    # ou npm run build para produção
    ```

7.  **Inicie o servidor de desenvolvimento Laravel:**
    ```bash
    php artisan serve
    ```
    A aplicação (API) estará disponível em `http://localhost:8000`.

## Endpoints da API (Exemplos)

*   `POST /api/produtos` - Cria um produto
*   `PUT /api/produtos/{id}` - Atualiza um produto
*   `POST /api/pedidos` - Cria um pedido (simula a compra)
*   `POST /api/cupons` - Cria um cupom
*   `POST /api/pedidos/webhook` - Webhook para status de pedidos
*   Consulte `routes/api.php` para a lista completa de rotas.

## (Opcional) Executando os Testes

O projeto possui testes de feature. Você pode executá-los com:
```bash
php artisan test
```

---
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
(Você pode manter esta licença do Laravel ou adicionar a sua própria se desejar).
