<script setup lang="ts">
import { AlertDialogAction } from 'reka-ui';
import { cn } from '@/lib/utils';
import { buttonVariants } from '@/components/ui/button';

interface Props {
    class?: string;
    asChild?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    class: '',
    asChild: false,
});
</script>

<template>
    <AlertDialogAction 
        :class="cn(buttonVariants(), props.class)"
        :as-child="props.asChild"
    >
        <slot />
    </AlertDialogAction>
</template>