<!DOCTYPE html>
<html>
<head>
    <title>Pedido Finalizado</title>
</head>
<body>
    <h1>Seu pedido foi finalizado com sucesso!</h1>
    
    <h2>Detalhes do Pedido</h2>
    <p>Número do Pedido: {{ $pedido->id }}</p>
    <p>Status: {{ $pedido->status }}</p>
    
    <h3>Itens do Pedido:</h3>
    <ul>
    @foreach($pedido->itens as $item)
        <li>
            Produto ID: {{ $item['produto_id'] }} - 
            Quantidade: {{ $item['quantidade'] }} - 
            Preço: R$ {{ number_format($item['preco'], 2, ',', '.') }}
        </li>
    @endforeach
    </ul>

    <p>Subtotal: R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</p>
    <p>Frete: R$ {{ number_format($pedido->frete, 2, ',', '.') }}</p>
    <p>Total: R$ {{ number_format($pedido->total, 2, ',', '.') }}</p>

    <h3>Endereço de Entrega:</h3>
    <p>
        {{ $pedido->endereco['logradouro'] }}<br>
        {{ $pedido->endereco['bairro'] }}<br>
        {{ $pedido->endereco['localidade'] }} - {{ $pedido->endereco['uf'] }}<br>
        CEP: {{ $pedido->endereco['cep'] }}
    </p>
</body>
</html>
