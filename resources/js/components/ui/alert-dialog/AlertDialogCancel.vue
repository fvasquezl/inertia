<script setup lang="ts">
import { AlertDialogCancel } from 'reka-ui';
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
    <AlertDialogCancel 
        :class="cn(buttonVariants({ variant: 'outline' }), props.class)"
        :as-child="props.asChild"
    >
        <slot />
    </AlertDialogCancel>
</template>