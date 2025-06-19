<script setup lang="ts">
import { ChevronLast } from 'lucide-vue-next';
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
        aria-label="Go to last page"
    >
        <ChevronLast class="h-4 w-4" />
    </PaginationLink>
</template>