<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <tr
        :class="
            cn(
                'border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted',
                props.class
            )
        "
    >
        <slot />
    </tr>
</template>