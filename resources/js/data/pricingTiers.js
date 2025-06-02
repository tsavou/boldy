export const tiers = [
    {
        name: 'Free',
        id: 'tier-free',
        href: route('register'),
        description:
            'Rejoignez la communauté Boldy et devenez visible sur la plateforme.\n \nCréez et personnalisez votre profil freelance gratuitement.',
        features: [
            'Création de profil',
            'Validation du statut freelance',
            'Visibilité sur la plateforme',
        ],
        mostPopular: false,
        cta: 'Devenir Bolder',
    },
    {
        name: 'Boost',
        id: 'tier-boost',
        href: '',
        priceFrequency: [
            { id: '7_days', price: '6,99 €', frequency: '7 jours' },
            { id: '14_days', price: '10,99 €', frequency: '14 jours' },
            { id: '30_days', price: '18,99 €', frequency: '30 jours' },
        ],
        description:
            '7, 14 ou 30 jours de boost pour augmenter votre visibilité.',
        features: [
            'Apparition en haut des résultats de recherche',
            "Mise en avant sur la page d'accueil",
            'Visibilité accrue sur la plateforme',
        ],
        mostPopular: true,
        cta: 'Obtenir un boost',
    },
    {
        name: 'Premium',
        id: 'tier-premium',
        href: '#',
        priceFrequency: [
            { id: 'premium_monthly', price: '29,99 €', frequency: 'Mensuel' },
            { id: 'premium_yearly', price: '290,99 €', frequency: 'Annuel' },
        ],
        description:
            'Un accompagnement personnalisé et une visibilité maximale.',
        features: [
            'Boost permanent',
            'Accompagnement personnalisé',
            'Boldy analytics',
            'Shooting photos',
        ],
        mostPopular: false,
        cta: 'Devenir Premium',
    },
];
