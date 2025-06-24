# Boldy – Plateforme de visibilité pour freelances

**Boldy** est une application web développée dans le cadre de mon projet de formation CDA (Concepteur Développeur d'Applications). Elle vise à offrir aux freelances une vitrine professionnelle centralisée, tout en permettant aux recruteurs de découvrir facilement des profils vérifiés.

🔗 **Lien vers le site en ligne** : [https://boldy.laravel.cloud/](https://boldy.laravel.cloud/)

## 🚀 Fonctionnalités principales

- Création de profils freelances personnalisés (bio, expérience, compétences, médias, etc.)
- Moteur de recherche avancé avec filtres dynamiques
- Système de vérification des freelances (SIRET + pièce d'identité)
- Options payantes : boost de visibilité, abonnements premium
- Interface admin pour validation des profils
- Paiement en ligne via Stripe (Laravel Cashier)
- Authentification complète avec Laravel Breeze
- Responsive design optimisé pour mobile

## 🛠️ Stack technique

- **Backend :** Laravel 12
- **Frontend :** Vue 3 + Inertia.js
- **CSS :** Tailwind CSS
- **Starter Kit :** Laravel Breeze (auth, Inertia SSR...)
- **Base de données :** MySQL (hébergée sur Laravel Cloud)
- **Paiement :** Stripe (test mode avec Cashier)
- **Hébergement & CI/CD :** Laravel Cloud
- **Outils de dev :** Docker avec Laravel Sail, PHPUnit, ESLint, Prettier


## 📦 Installation locale (via Sail)

### Cloner le projet

```bash
git clone https://github.com/tsavou/boldy.git
cd boldy
```

### Installation des dépendances

Si tu n’as pas encore Laravel Sail installé (ou le dossier vendor/), tu peux installer les dépendances PHP avec Docker directement :

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
Cela permet d’utiliser Composer sans l’installer sur ta machine locale, en s’appuyant sur l’image Docker officielle de Laravel Sail.

### . Lancer l’environnement Docker
```bash
./vendor/bin/sail up -d
```

### Installer les dépendances JS
```bash
./vendor/bin/sail npm install
```

### Configurer les variables d’environnement
```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

### Créer la base et l’alimenter avec des données de test
```bash
./vendor/bin/sail artisan migrate --seed
```

### Lancer le serveur local 

```bash
./vendor/bin/sail npm run dev
```

### Configuration stripe

L’intégration des paiements sur Boldy repose sur Stripe via Laravel Cashier. Pour utiliser les fonctionnalités de paiement (abonnements Premium, Boost, etc.), vous devez renseigner les variables suivantes dans votre fichier .env :
```dotenv
STRIPE_KEY=pk_test_votre_cle_publique
STRIPE_SECRET=sk_test_votre_cle_secrete
```
Vous pouvez récupérer ces clés sur votre Dashboard Stripe, dans la section Developers > API keys

## 👤 Accès Shell dans le conteneur Docker

Pour exécuter des commandes (`composer`, `npm`, `artisan`, etc.) :

```bash
./vendor/bin/sail shell
```

### 🌟 Créer un alias pour plus de confort

```bash
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc && source ~/.bashrc
```

Ensuite, vous pouvez maintenant utiliser simplement `sail` au lieu de `./vendor/bin/sail`

#### ⚠️ Ne jamais exécuter `composer`, `npm` ou `artisan` en dehors de Sail. Toujours utiliser `sail {npm, composer, artisan...}`

## 🧪 Tests & données

- Données réalistes générées avec **Factories** et **Seeders**
- Tests unitaires avec **PHPUnit**
- Environnements `preprod` / `prod` gérés avec Laravel Cloud

## 🔧 Outils de développement inclus

### ✅ Mailpit

- Outil de test d’envoi d’e-mails en local (similaire à Mailtrap mais gratuit et local)
- URL par défaut : http://localhost:8025
- Port configurable via .env → FORWARD_MAILPIT_DASHBOARD_PORT

### ✅ MySQL
- **Host:** 127.0.0.1
- **User :** Check .env → ${DB_USERNAME}
- **Password:** Check .env → ${DB_PASSWORD} 
- **Database:** Check .env → ${DB_DATABASE} 
- **Port:** Check .env → ${FORWARD_DB_PORT}
- **Documentation officielle MySQL** : https://dev.mysql.com/doc/
 
