export default defineNuxtConfig({
    extends: ['docus'],
    css: ['~/assets/css/main.css'],
    image: {
        provider: 'none',
    },
    content: {
        build: {
            markdown: {
                highlight: {
                    langs: ['bash', 'diff', 'json', 'js', 'ts', 'html', 'css', 'vue', 'shell', 'mdc', 'md', 'yaml', 'php'],
                },
            },
        },
    },
    site: {
        name: 'PHP Client for Cloudflare API',
        description: 'This package provides convenient access to the Cloudflare REST API using PHP.',
        url: 'https://sergkeim.github.io',
    },
    robots: {
        robotsTxt: false,
    },
    app: {
        baseURL: '/php-cloudflare-api/',
        head: {
            meta: [
                { name: 'google-site-verification', content: 'OFESQNvn-uXORi6W7u2vYanv-aORRNQNAT5twFPUJ_E' },
            ],
        },
    }
})