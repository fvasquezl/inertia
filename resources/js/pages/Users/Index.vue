<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head,router } from '@inertiajs/vue3';
import UsersTable from '@/components/UsersTable.vue';
import UserEditModal from '@/components/UserEditModal.vue';
import { route } from 'ziggy-js';
import type { User } from '@/types';
import { computed } from 'vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

const props = defineProps<{
    users: User[];
    editUser?: User
}>();

const showModal = computed(() => !!props.editUser);


function openEditModal(id: number) {
    router.get(route('users.index'), { edit_user: id}, {
        preserveState: true,
        preserveScroll: true,
        only: ['editUser'],
    });
}

function closeModal() {
    router.get(route('users.index'), {}, {
        preserveState: true,
        preserveScroll: true,
        only: ['users','editUser'],
        replace: true,
    });
}


</script>

<template>

    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-20 py-10 sm:px-6 lg:px-8">
            <UsersTable :people="props.users"  @edit-user="openEditModal" />
        </div>
        <UserEditModal
            v-if="showModal"
            :show="showModal"
            :user="props.editUser"
            @close="closeModal" />
    </AppLayout>
</template>
