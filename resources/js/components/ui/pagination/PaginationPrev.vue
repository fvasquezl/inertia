<script setup lang="ts">
import { ChevronLeft } from 'lucide-vue-next';
import PaginationLink from './PaginationLink.vue';

interface Props {
    href?: string;
    disabled?: boolean;
    class?: string;
}

const props = defineProps<Props>();
</script>

<template>
    <PaginationLink
        :href="href"
        :disabled="disabled"
        :class="props.class"
        aria-label="Go to previous page"
    >
        <ChevronLeft class="h-4 w-4" />
    </PaginationLink>
</template>