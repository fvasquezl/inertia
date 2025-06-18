<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import UserEdit from '@/components/UsersEdit.vue';

import type { User } from '@/types';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users Edit',
        href: '/users',
    },
];
const props = defineProps<{
    user: User;
}>();

</script>

<template>

    <Head title="Users" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-3">
            <UserEdit :user="props.user" />
        </div>
    </AppLayout>
</template>
