<template>
    <div class="flex flex-col items-center justify-center mt-10">
        <Card class="w-full max-w-xl p-8">
            <CardHeader class="text-center bg-gray-100 p-4 rounded-t-md">
                <h2 class="font-bold">Create User</h2>
            </CardHeader>
            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="mt-2">
                    <Label for="name">User Name</Label>
                    <Input type="text" id="name" name="name" class="mt-3 mb-4" :tabindex="1" placeholder="UserName"
                        v-model="form.name" />
                     <InputError :message="form.errors.name" />
                    <Label for="email">Email address</Label>
                    <Input id="email" name="email" type="email" class="mt-3 mb-4" :tabindex="1" v-model="form.email"
                        placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                    <Label for="password">Password</Label>
                    <Input id="password" name="password" type="password" class="mt-3 mb-4" :tabindex="1"
                        placeholder="Password" v-model="form.password" />
                    <InputError :message="form.errors.password" />
                    <Label for="passwordConfirm">Password Confirm</Label>
                     <Input id="passwordConfirm" name="passwordConfirm" type="password" class="mt-3 mb-4" :tabindex="1"
                        placeholder="Password Confirmation" v-model="form.passwordConfirm" />
                    <InputError :message="form.errors.passwordConfirm" />
                </div>
                <CardFooter class="flex flex-row gap-3">
                    <Button type="button" class="mt-4 flex-1" :tabindex="4" variant="secondary">
                        Cancel
                    </Button>
                    <Button type="submit" class="mt-4 flex-1" :tabindex="4" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Submit
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </div>
</template>

<script setup>
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/vue3';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import InputError from '@/components/InputError.vue';
import { LoaderCircle } from 'lucide-vue-next';

const submit = () => {
    form.post('/users', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error('Form submission failed:', errors);
        },
    });
};
const form = useForm({
    name: '',
    email: '',
    password: '',
    passwordConfirm: '',
    errors: {},
    processing: false,
});


</script>