<template>
    <USeparator class="hidden lg:flex" />

    <UContainer class="hidden lg:flex items-center justify-between">
        <UNavigationMenu
            :items="sections"
            :highlight="navMenuVariants.highlight ?? true"
            :highlight-color="navMenuVariants.highlightColor"
            :variant="navMenuVariants.variant ?? 'pill'"
            :color="navMenuVariants.color"
            class="-mx-2.5 -mb-px"
        />

        <AppHeaderBottomRight />
    </UContainer>
</template>

<script setup lang="ts">
    import type { ContentNavigationItem } from '@nuxt/content'

    // Docus builds this row from the top-level sections that have children, so a
    // single-page section — Coverage — never appears at all. Every top-level
    // entry is listed here instead: one with children opens at its first page,
    // one without opens itself.
    const route = useRoute()
    const navigation = inject<Ref<ContentNavigationItem[]>>('navigation')

    const navMenuVariants = useUIConfig('navigationMenu')

    function firstPage(item: ContentNavigationItem): string {
        let current = item

        while (current.children?.length) {
            current = current.children[0]!
        }

        return current.path
    }

    const sections = computed(() => (navigation?.value || []).map(item => ({
        label: item.title,
        icon: item.icon as string | undefined,
        to: item.children?.length ? firstPage(item) : item.path,
        active: route.path === item.path || route.path.startsWith(item.path + '/'),
    })))
</script>
