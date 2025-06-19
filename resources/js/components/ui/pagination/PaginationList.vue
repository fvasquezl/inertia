<script setup lang="ts">
import { cn } from '@/lib/utils';

interface Props {
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    class: '',
});
</script>

<template>
    <ul
        class="flex flex-row items-center gap-1"
        :class="cn(props.class)"
    >
        <slot />
    </ul>
</template>