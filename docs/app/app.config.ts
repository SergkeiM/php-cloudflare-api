export default defineAppConfig({
    navigation: {
        sub: 'header',
    },
    header: {
        title: 'PHP Client for Cloudflare API',
        logo: {
            light: '/logo-dark.png',
            dark: '/logo-light.png',
            alt: 'PHP Client for Cloudflare API',
        },
    },
    github: {
        owner: 'SergkeiM',
        repo: 'php-cloudflare-api',
        branch: 'master',
        rootDir: 'docs',
    },
    toc: {
        bottom: {
            links: [
                {
                    icon: 'i-lucide-book-open',
                    label: 'Cloudflare Fundamentals',
                    to: 'https://developers.cloudflare.com/fundamentals/',
                    target: '_blank',
                },
                {
                    icon: 'i-lucide-book-open',
                    label: 'Cloudflare API Docs',
                    to: 'https://developers.cloudflare.com/api/',
                    target: '_blank',
                },
            ],
        },
    },
    ui: {
        colors: {
            primary: 'cloudflare',
            neutral: 'gray',
        },
    },
})
