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

### 1. Cloner le projet

```bash
git clone https://github.com/tsavou/boldy.git
cd boldy
```

### 2. Lancer l’environnement Docker
```bash
./vendor/bin/sail up -d
```

### 3. Installer les dépendances PHP et JS
```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

### 4. Configurer les variables d’environnement
```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

### 5. Créer la base et l’alimenter avec des données de test
```bash
./vendor/bin/sail artisan migrate --seed
```

### 6. Lancer le serveur local 

```bash
sail npm run dev
```

### Configuration stripe

L’intégration des paiements sur Boldy repose sur Stripe via Laravel Cashier. Pour utiliser les fonctionnalités de paiement (abonnements Premium, Boost, etc.), vous devez renseigner les variables suivantes dans votre fichier .env :
```dotenv
STRIPE_KEY=pk_test_votre_cle_publique
STRIPE_SECRET=sk_test_votre_cle_secrete
```
Vous pouvez récupérer ces clés sur votre Dashboard Stripe, dans la section Developers > API keys


## 🧪 Tests & données

- Données réalistes générées avec **Factories** et **Seeders**
- Tests unitaires avec **PHPUnit**
- Environnements `preprod` / `prod` gérés avec Laravel Cloud
