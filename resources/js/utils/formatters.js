// resources/js/utils/formatters.js

export function formatExperience(years) {
    if (years < 1) return '< 1 an';
    if (years > 1) return `${years} ans`;
    return ' 1 an';
}
