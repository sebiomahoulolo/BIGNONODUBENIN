# Configuration Email - Bignon du Bénin

## Problème actuel
Les emails ne sont pas envoyés car la configuration utilise le driver 'log' par défaut, ce qui signifie que les emails sont seulement enregistrés dans les logs et ne sont pas réellement envoyés.

## Solution : Configuration SMTP

### 1. Configuration dans le fichier .env

Ajoutez ou modifiez ces lignes dans votre fichier `.env` :

```env
# Configuration Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=bignondubenin1@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
MAIL_TO_ADDRESS=bignondubenin1@gmail.com
```

### 2. Pour Gmail spécifiquement

Si vous utilisez Gmail, vous devez :
1. Activer l'authentification à deux facteurs
2. Générer un "Mot de passe d'application" :
   - Allez dans votre compte Google
   - Sécurité > Authentification à deux facteurs
   - Mots de passe des applications
   - Créez un nouveau mot de passe d'application
   - Utilisez ce mot de passe dans `MAIL_PASSWORD`

### 3. Autres services SMTP

#### Mailtrap (pour les tests)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre-username-mailtrap
MAIL_PASSWORD=votre-password-mailtrap
MAIL_ENCRYPTION=tls
```

#### SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=votre-api-key-sendgrid
MAIL_ENCRYPTION=tls
```

### 4. Vérification

Après avoir configuré, testez avec :
```bash
php artisan tinker
Mail::raw('Test email', function ($message) {
    $message->to('votre-email@example.com')
            ->subject('Test');
});
```

### 5. Logs

Si les emails ne fonctionnent toujours pas, vérifiez les logs :
- `storage/logs/laravel.log` pour les erreurs
- Les logs afficheront les erreurs détaillées si `APP_DEBUG=true`

### 6. Mode développement

En mode développement, vous pouvez utiliser le driver 'log' pour voir les emails dans les logs :
```env
MAIL_MAILER=log
```
Les emails seront alors visibles dans `storage/logs/laravel.log`
