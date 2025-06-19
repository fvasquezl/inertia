<script setup lang="ts">
import { AlertDialogDescription } from 'reka-ui';
import { cn } from '@/lib/utils';

interface Props {
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    class: '',
});
</script>

<template>
    <AlertDialogDescription :class="cn('text-sm text-muted-foreground', props.class)">
        <slot />
    </AlertDialogDescription>
</template>