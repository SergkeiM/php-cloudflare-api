export default defineNuxtConfig({
    ssr: false,
    extends: '@nuxt-themes/docus',
    modules: ['@nuxtjs/tailwindcss'],
    sourcemap: {
        server: false,
        client: false
    }
})