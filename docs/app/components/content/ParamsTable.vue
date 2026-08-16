<script setup lang="ts">
interface Param {
  name: string
  type: string
  required?: boolean
  default?: string
  description?: string
  /** Page for the configuration helper this parameter accepts, when it accepts one. */
  configuration?: string
}

defineProps<{
  params: Param[]
}>()
</script>

<template>
  <ProseTable>
    <ProseThead>
      <ProseTr>
        <ProseTh>Param</ProseTh>
        <ProseTh>Type</ProseTh>
        <ProseTh>Required</ProseTh>
        <ProseTh>Default</ProseTh>
        <ProseTh>Description</ProseTh>
      </ProseTr>
    </ProseThead>
    <ProseTbody>
      <ProseTr v-for="param in params" :key="param.name">
        <ProseTd>
          <ProseCode>{{ param.name }}</ProseCode>
        </ProseTd>
        <ProseTd>
          <!--
            A parameter that accepts a configuration helper links to the page
            explaining how to build one, so the reader does not have to guess
            what `Ruleset` in `Ruleset|array` refers to.
          -->
          <ProseA
            v-if="param.configuration"
            :href="param.configuration"
          >
            <ProseCode>{{ param.type }}</ProseCode>
          </ProseA>
          <ProseCode v-else>{{ param.type }}</ProseCode>
        </ProseTd>
        <ProseTd>
          <UBadge
            :color="param.required ? 'error' : 'success'"
            variant="subtle"
            size="sm"
          >
            {{ param.required ? 'Yes' : 'No' }}
          </UBadge>
        </ProseTd>
        <ProseTd>
          <ProseCode v-if="param.default">{{ param.default }}</ProseCode>
        </ProseTd>
        <ProseTd>
          <span v-if="param.description">{{ param.description }}</span>
        </ProseTd>
      </ProseTr>
    </ProseTbody>
  </ProseTable>
</template>
