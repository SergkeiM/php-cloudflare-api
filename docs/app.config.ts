export default defineAppConfig({
    docus: {
        title: 'PHP Cloudflare API',
        description: 'A simple Object Oriented wrapper for Cloudflare API, written with PHP.',
        layout: 'default',
        image: '/preview.png',
        url: 'https://php-cloudflare-api.vercel.app',
        socials: {
            github: 'SergkeiM/php-cloudflare-api'
        },
        github: {
            owner: 'SergkeiM',
            repo: 'php-cloudflare-api',
            branch: 'master',
            dir: 'docs/content',
            edit: true
        },
        aside: {
            level: 1,
        },
        header: {
            logo: {
                dark: '/logo-new.png',
                light: '/logo-new.png',
            },
        },
        footer: {
            textLinks: [
                {
                    target: '_blank',
                    text: 'Cloudflare Fundamentals',
                    href: 'https://developers.cloudflare.com/fundamentals/'
                },
                {
                    target: '_blank',
                    text: 'Cloudflare API Docs',
                    href: 'https://developers.cloudflare.com/api/'
                }
            ]
        },
    },
})