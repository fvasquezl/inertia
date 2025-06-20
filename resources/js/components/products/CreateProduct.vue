<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue'

// Components
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
import { Textarea } from '@/components/ui/textarea';

const emit = defineEmits(['product-created']);

const form = useForm({
    name: '',
    description: '',
    price: '',
    image: null as File | null,
});
const open = ref(false);

const handleImageChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image = target.files[0];
    } else {
        form.image = null;
    }
};

const createProduct = (e: Event) => {
    e.preventDefault();

    form.post(route('products.store'), {
        preserveScroll: true,
        forceFormData: true,
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
    open.value = false; // 2. Cierra el modal
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <div class="space-y-6">
        <Dialog v-model:open="open">
            <DialogTrigger as-child>
                <Button variant="default" @click="open = true">Create Product</Button>
            </DialogTrigger>
            <DialogContent>
                <form class="space-y-6" @submit="createProduct">
                    <DialogHeader class="space-y-3">
                        <DialogTitle>Create Product</DialogTitle>
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
                        <Textarea id="description" name="description" v-model="form.description"
                            placeholder="Product description" />
                        <InputError :message="form.errors.description" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="price">Price</Label>
                        <Input id="price" type="number" step="0.01" min="0" name="price" v-model="form.price"
                            placeholder="0.00" />
                        <InputError :message="form.errors.price" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="image">Image</Label>
                        <Input id="image" type="file" name="image" accept="image/*" @change="handleImageChange" />
                        <InputError :message="form.errors.image" />
                    </div>

                    <DialogFooter class="gap-2">
                        <DialogClose as-child>
                            <Button variant="secondary" @click="closeModal"> Cancel </Button>
                        </DialogClose>

                        <Button type="submit" variant="default" :disabled="form.processing"> Create Product
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </div>
</template>
