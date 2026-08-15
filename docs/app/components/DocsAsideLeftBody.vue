<template>
    <UContentNavigation
        :collapsible="true"
        :highlight="contentNavVariants.highlight ?? true"
        :highlight-color="contentNavVariants.highlightColor"
        :variant="contentNavVariants.variant ?? 'link'"
        :color="contentNavVariants.color"
        :navigation="navigation"
    />
</template>
<script setup lang="ts">
    const { sidebarNavigation } = useSubNavigation()

    const contentNavVariants = useUIConfig('contentNavigation')

    // The Client Reference is one entry per endpoint, ordered by how the client
    // registers them. Group it by what the endpoints do before rendering.
    const navigation = computed(() => withGroupedClientNavigation(sidebarNavigation.value))
</script>
