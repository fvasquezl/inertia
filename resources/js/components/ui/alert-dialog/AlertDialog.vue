<script setup lang="ts">
import { AlertDialogRoot } from 'reka-ui';

interface Props {
    open?: boolean;
    defaultOpen?: boolean;
}

interface Emits {
    (e: 'update:open', value: boolean): void;
}

const props = defineProps<Props>();
const emits = defineEmits<Emits>();
</script>

<template>
    <AlertDialogRoot
        :open="props.open"
        :default-open="props.defaultOpen"
        @update:open="(value: boolean) => emits('update:open', value)"
    >
        <slot />
    </AlertDialogRoot>
</template>