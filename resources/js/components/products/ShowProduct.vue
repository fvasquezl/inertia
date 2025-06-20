<script setup lang="ts">
import type { Product } from '@/types/products';
import { computed } from 'vue';

const props = defineProps<{ product: Product }>();

const imageUrl = computed(() => {
    if (!props.product.image) return null;
    // Asume que la ruta guardada es relativa a storage/app/public
    return `/storage/${props.product.image}`;
});
</script>

<template>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">{{ product.name }}</h2>
        <div v-if="imageUrl" class="mb-4">
            <img :src="imageUrl" :alt="product.name" class="max-w-xs rounded shadow" />
        </div>
        <p class="text-muted-foreground">{{ product.description }}</p>
        <div class="text-lg font-semibold">${{ product.price.toFixed(2) }}</div>
    </div>
</template>
