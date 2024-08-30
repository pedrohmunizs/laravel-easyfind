<h6>Olá, {{ $data['toName'] }}</h6>
<p>Você acabou de receber um novo pedido através da EasyFind! 🎉</p>
<p>Total: R${{ $data['email']['valor'] }}</p>
<a href="http://localhost/pedidos/{{ $data['email']['estabelecimento'] }}/show/{{ $data['email']['id'] }}" target=”blank”>Veja aqui</a>