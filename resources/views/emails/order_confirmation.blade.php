<h1>Bonjour {{ $order->customer?->name ?? 'Client' }},</h1>

<p>Votre commande {{ $order->order_number }} est en cours de traitement.</p>

<h3>Détails de votre commande :</h3>
<ul>
    @foreach($order->items as $item)
        <li>{{ $item->quantity }} x {{ $item->product->name }} - {{ $item->price }} FCFA</li>
    @endforeach
</ul>

<p>Total : {{ $order->total_amount }} FCFA</p>
<p>Nous vous tiendrons informé de son avancement.</p>

<p>Pour toute question, contactez-nous sur WhatsApp : <a href="https://wa.me/+22997069305">WhatsApp</a></p>

<p>Merci pour votre confiance !</p>
