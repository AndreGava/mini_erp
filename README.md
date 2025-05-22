# Mini ERP para Controle de Pedidos

Este projeto é uma solução de Mini ERP desenvolvida para gerenciar o controle de pedidos, produtos, estoque e cupons de desconto. Foi criado como parte de um teste técnico utilizando o framework Laravel para o backend, oferecendo uma API robusta para operações comuns em sistemas de vendas.

---

## Funcionalidades Principais

- Cadastro, atualização e gerenciamento de Produtos, incluindo variações e preços.
- Controle detalhado de Estoque associado a cada produto e suas variações.
- Sistema de Carrinho de Compras gerenciado por sessão do usuário.
- Cálculo dinâmico de Frete baseado no subtotal do pedido.
- Validação e consulta de CEP utilizando a API ViaCEP.
- Gerenciamento de Cupons de Desconto com controle de validade e valor mínimo para aplicação.
- Finalização de Pedidos com envio automático de e-mail de confirmação para o cliente.
- Webhook para atualização automática do status dos pedidos.

---

## Tecnologias Utilizadas

- **Backend:** PHP 8.2 ou superior, Laravel 11.x
- **Banco de Dados:** MySQL
- **Frontend (compatível):** Bootstrap, HTML, CSS, JavaScript
- **Gerenciamento de Dependências:** Composer (PHP), NPM (JavaScript)

---

## Pré-requisitos para Configuração

- PHP 8.2 ou superior
- Composer instalado
- Node.js e NPM instalados
- Servidor MySQL configurado
- Servidor web (Apache, Nginx) para produção ou uso do servidor embutido do Laravel para desenvolvimento

---

## Instruções de Instalação e Configuração

1. Clone o repositório:
   ```bash
   git clone https://github.com/AndreGava/mini_erp.git
   cd mini_erp
   ```

2. Instale as dependências PHP via Composer:
   ```bash
   composer install
   ```

3. Copie o arquivo de ambiente e configure as variáveis:
   ```bash
   cp .env.example .env
   ```
   Edite o arquivo `.env` para configurar o banco de dados e outras variáveis, como:
   ```
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mini_erp
   DB_USERNAME=root
   DB_PASSWORD=SUA_SENHA_DO_MYSQL_AQUI
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.exemplo.com
   MAIL_PORT=587
   MAIL_USERNAME=seu_email@exemplo.com
   MAIL_PASSWORD=sua_senha
   MAIL_ENCRYPTION=tls
   ```

4. Gere a chave da aplicação Laravel:
   ```bash
   php artisan key:generate
   ```

5. Execute as migrations para criar a estrutura do banco de dados:
   ```bash
   php artisan migrate
   ```

6. (Opcional) Execute os seeders para popular o banco com dados iniciais:
   ```bash
   php artisan db:seed
   ```

7. Instale as dependências JavaScript e compile os assets:
   ```bash
   npm install
   npm run dev
   ```

8. Inicie o servidor de desenvolvimento:
   ```bash
   php artisan serve
   ```
   A aplicação estará disponível em `http://localhost:8000`.

---

## Endpoints Principais da API

- `POST /api/produtos` - Cria um novo produto.
- `PUT /api/produtos/{id}` - Atualiza um produto existente.
- `POST /api/pedidos` - Cria um novo pedido (simula uma compra).
- `POST /api/cupons` - Cria um novo cupom de desconto.
- `POST /api/pedidos/webhook` - Endpoint para webhook de atualização de status de pedidos.

Consulte o arquivo `routes/api.php` para a lista completa de rotas disponíveis.

---

## Executando os Testes

O projeto possui testes automatizados de feature. Para executá-los, utilize o comando:

```bash
php artisan test
```

---

## Licença

Este projeto utiliza a licença MIT, assim como o framework Laravel. Você pode manter esta licença ou adicionar a sua própria conforme necessário.

---

## Contato

Para dúvidas ou contribuições, entre em contato com o desenvolvedor responsável pelo projeto.
