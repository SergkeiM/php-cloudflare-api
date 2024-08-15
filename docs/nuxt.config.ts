export default defineNuxtConfig({
    extends: '@nuxt-themes/docus',
    app: {
        head: {
            meta: [
                {name: 'google-site-verification', content: 'OFESQNvn-uXORi6W7u2vYanv-aORRNQNAT5twFPUJ_E'}
            ]
        }
    },
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