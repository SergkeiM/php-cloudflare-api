export default defineNuxtConfig({
    extends: '@nuxt-themes/docus',
    modules: ['@nuxtjs/tailwindcss'],
    sourcemap: {
        server: false,
        client: false
    }
})