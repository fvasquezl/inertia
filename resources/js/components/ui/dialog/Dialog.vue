<script setup lang="ts">
import { DialogRoot, type DialogRootEmits, type DialogRootProps, useForwardPropsEmits } from 'reka-ui'
import { AlertDialogRoot } from 'reka-ui'
import { computed } from 'vue'

interface BaseProps {
  type?: 'default' | 'alert';
  open?: boolean;
  defaultOpen?: boolean;
}

const props = defineProps<BaseProps & DialogRootProps>()
const emits = defineEmits(['update:open'])

const forwarded = useForwardPropsEmits(props, emits)
const isAlert = computed(() => props.type === 'alert')
</script>

<template>
  <component :is="isAlert ? AlertDialogRoot : DialogRoot" data-slot="dialog" v-bind="forwarded" :open="props.open"
    :default-open="props.defaultOpen" @update:open="(value: boolean) => emits('update:open', value)">
    <slot />
  </component>
</template>
