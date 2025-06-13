<template>
    <div>
        <TransitionRoot as="template" :show="show">
            <Dialog as="div" class="relative z-10" @close="emit('close')">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-start justify-center p-4 pt-20 text-center sm:items-start sm:p-0 sm:pt-24">
                        <TransitionChild
                            as="template"
                            enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to="opacity-100 translate-y-0 sm:scale-100"
                            leave="ease-in duration-200"
                            leave-from="opacity-100 translate-y-0 sm:scale-100"
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        >
                            <DialogPanel
                                class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                            >
                                <DialogTitle as="h3" class="mb-5 text-center font-semibold text-gray-900">User Edit </DialogTitle>
                                <form @submit.prevent="submit" class="flex flex-col gap-6">
                                    <div class="mt-2">
                                        <Label for="name">User Name</Label>
                                        <Input type="text"
                                               id="name"
                                               name="name"
                                               class="mt-3 mb-4"
                                               :tabindex="1"
                                               placeholder="UserName"
                                               v-model="form.name" />
                                        <Label for="email">Email address</Label>
                                        <Input
                                            id="email"
                                            name="email"
                                            type="email"
                                            class="mt-3 mb-4"
                                            :tabindex="1"
                                            v-model="form.email"
                                            placeholder="email@example.com"
                                        />
                                        <Label for="password">Password</Label>
                                        <Input
                                            id="password"
                                            name="password"
                                            type="password"
                                            class="mt-3 mb-4"
                                            :tabindex="1"
                                            placeholder="Password"
                                            v-model="form.password"
                                        />
                                    </div>
                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                        <Button @click="closeModal" type="button" class="mt-4 w-full" :tabindex="4" variant="secondary" >
                                            Cancel
                                        </Button>

                                        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                            Submit
                                        </Button>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script setup lang="ts">
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import type { User } from '@/types';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { LoaderCircle } from 'lucide-vue-next';

const emit = defineEmits(['close']);

function closeModal() {
    emit('close');
}

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};

const { show, user } = defineProps<{
    show: boolean;
    user?: User;
}>();

const form = useForm({
    name: user?.name,
    email: user?.email,
    password: '',
});
</script>
