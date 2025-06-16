<script setup lang="ts">
import CreateProduct from '@/components/CreateProduct.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];
</script>

<template>

    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <CreateProduct />
    </AppLayout>
</template>
