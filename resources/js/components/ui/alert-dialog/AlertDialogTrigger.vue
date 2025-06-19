<script setup lang="ts">
import { AlertDialogTrigger } from 'reka-ui';

interface Props {
    asChild?: boolean;
    disabled?: boolean;
}

const props = defineProps<Props>();
</script>

<template>
    <AlertDialogTrigger
        :as-child="props.asChild"
        :disabled="props.disabled"
    >
        <slot />
    </AlertDialogTrigger>
</template>