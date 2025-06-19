<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue'
import type { Product } from '@/types/products';

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
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

const props = defineProps<{
    product?: Product;
    modelValue: boolean;
}>();

const emit = defineEmits(['update:modelValue', 'product-updated']);

const form = useForm({
    name: '',
    description: '',
    price: '',
});

const open = ref(false);

// Sync open state with modelValue prop
watch(() => props.modelValue, (newValue) => {
    open.value = newValue;
    if (newValue && props.product) {
        // Load product data when modal opens
        form.name = props.product.name;
        form.description = props.product.description || '';
        form.price = props.product.price.toString();
    }
});

// Emit changes when dialog state changes
watch(open, (newValue) => {
    emit('update:modelValue', newValue);
});

const updateProduct = (e: Event) => {
    e.preventDefault();

    if (!props.product) return;

    form.put(route('products.update', props.product.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            emit('product-updated');
        },
        onError: () => {
            // Focus the first input with an error
            const firstErrorInput = document.querySelector('.input-error');
            if (firstErrorInput) {
                (firstErrorInput as HTMLInputElement).focus();
            }
        },
    });
};

const closeModal = () => {
    open.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent>
            <form class="space-y-6" @submit="updateProduct">
                <DialogHeader class="space-y-3">
                    <DialogTitle>Edit Product</DialogTitle>
                    <DialogDescription>
                        Update the product details below.
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-2">
                    <Label for="edit-name">Name</Label>
                    <Input id="edit-name" type="text" name="name" v-model="form.name" placeholder="Product Name" />
                    <InputError :message="form.errors.name" />
                </div>
                <div class="grid gap-2">
                    <Label for="edit-description">Description</Label>
                    <Textarea id="edit-description" name="description" v-model="form.description"
                        placeholder="Product description" />
                    <InputError :message="form.errors.description" />
                </div>
                <div class="grid gap-2">
                    <Label for="edit-price">Price</Label>
                    <Input id="edit-price" type="number" step="0.01" min="0" name="price" v-model="form.price" placeholder="0.00" />
                    <InputError :message="form.errors.price" />
                </div>

                <DialogFooter class="gap-2">
                    <DialogClose as-child>
                        <Button variant="secondary" @click="closeModal"> Cancel </Button>
                    </DialogClose>

                    <Button type="submit" variant="default" :disabled="form.processing"> Update Product
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>