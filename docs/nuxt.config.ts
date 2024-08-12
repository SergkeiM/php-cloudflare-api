export default defineNuxtConfig({
    extends: '@nuxt-themes/docus',
    content: {
        documentDriven: true,
        highlight: {
            theme: {
                dark: 'github-dark',
                default: 'github-light'
            },
            preload: ['json', 'js', 'ts', 'diff', 'markdown', 'yaml', 'bash', 'php']
        },
        navigation: {
            fields: ['icon', 'titleTemplate', 'header', 'main', 'aside', 'footer']
        }
    },
})