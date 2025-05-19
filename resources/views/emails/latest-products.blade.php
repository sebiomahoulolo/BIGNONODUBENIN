<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveaux produits disponibles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 700px; margin: auto; background: #fff; padding: 20px; border-radius: 10px;">

        {{-- En-tête avec logo --}}
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ $message->embed(public_path('images/logo_bignon.png')) }}" alt="{{ config('app.name') }}" width="120" style="border-radius: 5px;">
        </div>

        <h2 style="color: #366ba2;">Bonjour,</h2>

        <p>Nous avons le plaisir de vous présenter nos <strong>nouveaux produits</strong> récemment ajoutés à notre plateforme.</p>

        @foreach($products as $product)
    @if(!empty($product->images) && count($product->images) > 0)
        <div style="border: 1px solid #ff2c2c; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
            <table cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <td width="120">
                        <img src="{{ $message->embed(storage_path('app/public/' . $product->images[0])) }}" 
                             alt="{{ $product->name }}" width="100" style="border-radius: 5px;">
                    </td>
                    <td>
                        <h3 style="margin: 0; color: #333;">{{ $product->name }}</h3>
                        <p style="margin: 5px 0;">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                        <a href="{{ route('pages.product.detail', $product->id) }}" 
                           style="display: inline-block; background-color: #366ba2; color: #fff; padding: 8px 12px; 
                                  text-decoration: none; border-radius: 5px; margin-top: 5px;">
                            Voir ce produit
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    @endif
@endforeach


        {{-- Signature --}}
        <p style="margin-top: 30px;">
            Merci pour votre confiance,<br>
            <strong>L'équipe {{ config('app.name') }}</strong>
        </p>

        {{-- Réseaux sociaux --}}
        <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
        <p style="text-align: center; margin-top: 20px;">Suivez-nous sur nos réseaux :</p>
      <p style="text-align: center;">
            <a href="https://web.facebook.com/bignon00229?mibextid=ZbWKwL&_rdc=1&_rdr#" target="_blank" style="margin: 0 10px;">
                <img src="https://img.icons8.com/ios-filled/30/366ba2/facebook--v1.png" alt="Facebook">
            </a>
            <a href="https://wa.me/+22997069305" target="_blank" style="margin: 0 10px;">
                <img src="https://img.icons8.com/ios-filled/30/25d366/whatsapp.png" alt="WhatsApp">
            </a>
            <a href="https://www.tiktok.com/@229bignon1?_t=8kGBf86zCyM&_r=1" target="_blank" style="margin: 0 10px;">
                <img src="https://img.icons8.com/ios-filled/30/ff2c2c/tiktok.png" alt="TikTok">
            </a>
        </p>

        {{-- Pied de page --}}
        <p style="font-size: 12px; color: #888; text-align: center; margin-top: 30px;">
            © {{ date('Y') }} {{ config('app.name') }} – Tous droits réservés.
        </p>

    </div>
</body>
</html>