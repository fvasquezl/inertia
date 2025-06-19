<script setup lang="ts">
import { MoreHorizontal } from 'lucide-vue-next';
import { cn } from '@/lib/utils';

interface Props {
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    class: '',
});
</script>

<template>
    <span
        aria-hidden="true"
        class="flex h-9 w-9 items-center justify-center"
        :class="cn(props.class)"
    >
        <MoreHorizontal class="h-4 w-4" />
        <span class="sr-only">More pages</span>
    </span>
</template>