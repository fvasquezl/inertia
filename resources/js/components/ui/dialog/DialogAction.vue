<script setup lang="ts">
import { DialogClose } from 'reka-ui';
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
    <DialogClose :as-child="props.asChild">
        <button :class="cn(buttonVariants({ variant: 'destructive' }), props.class)">
            <slot />
        </button>
    </DialogClose>
</template>
