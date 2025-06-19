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
    <nav
        role="navigation"
        aria-label="pagination"
        class="mx-auto flex w-full justify-center"
        :class="cn(props.class)"
    >
        <slot />
    </nav>
</template>