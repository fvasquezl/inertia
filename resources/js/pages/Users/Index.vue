<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import UsersTable from '@/components/UsersTable.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

const props = defineProps<{
    users: Array<any>
}>();
</script>

<template>

    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-20 py-10 sm:px-6 lg:px-8">
            <UsersTable :people="props.users" />
        </div>
    </AppLayout>
</template>
