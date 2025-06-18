<template>
    <div class="mt-10 flex flex-col items-center justify-center">
        <Card class="w-full max-w-xl p-8">
            <CardHeader class="rounded-t-md bg-gray-100 p-4 text-center">
                <h2 class="font-bold">Edit User</h2>
            </CardHeader>
            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="mt-2">
                    <Label for="name">User Name</Label>
                    <Input type="text" id="name" name="name" class="mt-3 mb-4" :tabindex="1" placeholder="UserName" v-model="form.name" />
                    <InputError :message="form.errors.name" />
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
                    <InputError :message="form.errors.email" />
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
                    <InputError :message="form.errors.password" />
                    <Label for="passwordConfirm">Password Confirm</Label>
                    <Input
                        id="passwordConfirm"
                        name="passwordConfirm"
                        type="password"
                        class="mt-3 mb-4"
                        :tabindex="1"
                        placeholder="Password Confirmation"
                        v-model="form.passwordConfirm"
                    />
                    <InputError :message="form.errors.passwordConfirm" />
                </div>
                <CardFooter class="flex flex-row gap-3 align-middle">
                    <TextLink :href="route('users.index')" class="mt-4 ml-9 flex-1" :tabindex="4">Cancel</TextLink>
                    <Button type="submit" class="mt-4 flex-1" :tabindex="4" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Submit
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </div>
</template>
UsersCreate.vue

<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps({
    user: Object,
});
const submit = () => {
    form.put(route('users.update', props.user?.id), {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error('Form submission failed:', errors);
        },
    });
};


const form = useForm({
    name: props.user?.name,
    email: props.user?.email,
    password: '',
    passwordConfirm: '',
    errors: {},
    processing: false,
});
</script>
