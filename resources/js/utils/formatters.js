// resources/js/utils/formatters.js

export function formatExperience(years) {
    if (years < 1) return '< 1 an';
    if (years > 1) return `${years} ans`;
    return ' 1 an';
}

export function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    const months = [
        'Janvier',
        'Février',
        'Mars',
        'Avril',
        'Mai',
        'Juin',
        'Juillet',
        'Août',
        'Septembre',
        'Octobre',
        'Novembre',
        'Décembre',
    ];
    const month = months[date.getMonth()];
    const year = date.getFullYear();
    return `${month} ${year}`;
}
