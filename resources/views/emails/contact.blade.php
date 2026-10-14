<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau message de contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 700px; margin: auto; background: #fff; padding: 20px; border-radius: 10px;">
        <h2 style="color: #366ba2;">Nouveau message de contact</h2>
        
        <p>Vous avez reçu un nouveau message depuis le formulaire de contact de votre site web.</p>
        
        <div style="background-color: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Nom :</strong> {{ $name }}</p>
            <p><strong>Email :</strong> {{ $email }}</p>
            @if($phone)
            <p><strong>Téléphone :</strong> {{ $phone }}</p>
            @endif
            <p><strong>Sujet :</strong> {{ $subject }}</p>
        </div>
        
        <div style="margin: 20px 0;">
            <h3 style="color: #366ba2;">Message :</h3>
            <p style="white-space: pre-wrap;">{{ $messageContent }}</p>
        </div>
        
        <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
        
        <p style="font-size: 12px; color: #888; text-align: center; margin-top: 30px;">
            Ce message a été envoyé depuis le formulaire de contact de {{ config('app.name') }}.
        </p>
    </div>
</body>
</html>
