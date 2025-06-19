<script setup lang="ts">
import { AlertDialogTitle } from 'reka-ui';
import { cn } from '@/lib/utils';

interface Props {
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    class: '',
});
</script>

<template>
    <AlertDialogTitle :class="cn('text-lg font-semibold', props.class)">
        <slot />
    </AlertDialogTitle>
</template>