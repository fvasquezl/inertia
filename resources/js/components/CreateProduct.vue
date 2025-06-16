<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Components
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const emit = defineEmits(['product-created']);

const form = useForm({
    password: '',
    name: '',
    description: '',
    price: '',
});

const createProduct = (e: Event) => {
    e.preventDefault();

    form.post(route('products.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            emit('product-created');
        },
        onError: () => {
            // Focus the first input with an error
            const firstErrorInput = document.querySelector('.input-error');
            if (firstErrorInput) {
                (firstErrorInput as HTMLInputElement).focus();
            }
        },
        onFinish: () => form.reset(),
    });

};

const closeModal = () => {
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <div class="space-y-6">
        <Dialog>
            <DialogTrigger as-child>
                <Button variant="default">Create Product</Button>
            </DialogTrigger>
            <DialogContent>
                <form class="space-y-6" @submit="createProduct">
                    <DialogHeader class="space-y-3">
                        <DialogTitle>CreateProduct</DialogTitle>
                        <DialogDescription>
                            Form to create a new product. Please fill in the details below.
                        </DialogDescription>
                    </DialogHeader>

                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" type="text" name="name" v-model="form.name" placeholder="Product Name" />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="description">Description</Label>
                        <Input id="description" type="text" name="description" v-model="form.description"
                            placeholder="Product description" />
                        <InputError :message="form.errors.description" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="price">Price</Label>
                        <Input id="price" type="text" name="price" v-model="form.price" placeholder="Product price" />
                        <InputError :message="form.errors.price" />
                    </div>

                    <DialogFooter class="gap-2">
                        <DialogClose as-child>
                            <Button variant="secondary" @click="closeModal"> Cancel </Button>
                        </DialogClose>

                        <Button type="submit" variant="default" :disabled="form.processing"> Crate Product
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </div>
</template>
