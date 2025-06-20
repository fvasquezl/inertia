<script setup lang="ts">
import { ArrowDownUp, ArrowUp, ArrowDown } from 'lucide-vue-next';
const props = defineProps<{ direction?: 'asc' | 'desc', sortKey?: string, activeSort?: string }>();
</script>

<template>
    <ArrowUp v-if="props.activeSort === props.sortKey && props.direction === 'asc'"
        class="inline w-4 h-4 text-primary align-middle" />
    <ArrowDown v-else-if="props.activeSort === props.sortKey && props.direction === 'desc'"
        class="inline w-4 h-4 text-primary align-middle" />
    <ArrowDownUp v-else class="inline w-4 h-4 opacity-40 align-middle" />
</template>
