const version = process.env.NUXT_PUBLIC_APP_VERSION

export default defineAppConfig({
    docus: {
        title: 'PHP Client for Cloudflare API.',
        description: 'This package provides convenient access to the Cloudflare REST API using PHP.',
        layout: 'default',
        image: '/preview.png',
        url: 'https://php-cloudflare-api.nuxt.space/',
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
          collapsed: false,
        },
        header: {
            logo: {
                dark: '/logo-light.png',
                light: '/logo-dark.png',
            },
        },
        footer: {
            textLinks: [
                ...(version ? [{
                    target: '_blank',
                    text: version,
                    href: `https://github.com/SergkeiM/php-cloudflare-api/releases/tag/${version}`
                }] : []),
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