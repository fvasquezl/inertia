<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from '@/composables/useToast';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import type { Product } from '@/types/products';

const props = defineProps<{
    product: Product | undefined;
    open: boolean;
}>();
const emit = defineEmits(['update:open', 'product-deleted']);

const showDialog = ref(props.open);
const toast = useToast();

watch(() => props.open, (val) => {
    showDialog.value = val;
});
watch(showDialog, (val) => {
    emit('update:open', val);
});

const deleteProduct = () => {
    if (!props.product) return;
    router.delete(route('products.destroy', props.product.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDialog.value = false;
            emit('product-deleted');
        },
        onError: () => {
            toast.error('Failed to delete product');
        },
    });
};
</script>

<template>
    <Dialog v-model:open="showDialog" type="alert">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Are you sure?</DialogTitle>
                <DialogDescription>
                    This action cannot be undone. This will permanently delete the product
                    <span class="font-semibold">{{ product?.name }}</span>.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">Cancel</Button>
                </DialogClose>
                <DialogClose as-child>
                    <Button variant="destructive" @click="deleteProduct">Delete</Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
