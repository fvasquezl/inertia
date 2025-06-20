<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import CreateProduct from '@/components/CreateProduct.vue';
import EditProduct from '@/components/EditProduct.vue';
import { useToast } from '@/composables/useToast';
import type { Product } from '@/types/products';
import type { PaginatedData } from '@/types/pagination';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationLink,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from '@/components/ui/pagination';
import { Pencil, Trash2 } from 'lucide-vue-next';

const props = defineProps<{
    products: PaginatedData<Product>;
}>();

const toast = useToast();
const editingProduct = ref<Product | undefined>();
const showEditModal = ref(false);
const deletingProduct = ref<Product | undefined>();
const showDeleteDialog = ref(false);

const handleProductCreated = () => {
    toast.success('Product created successfully!');
    router.reload({ only: ['products'] });
};

const handleProductUpdated = () => {
    toast.success('Product updated successfully!');
    router.reload({ only: ['products'] });
};

const editProduct = (product: Product) => {
    editingProduct.value = product;
    showEditModal.value = true;
};

const confirmDelete = (product: Product) => {
    deletingProduct.value = product;
    showDeleteDialog.value = true;
};

const deleteProduct = () => {
    if (!deletingProduct.value) return;

    router.delete(route('products.destroy', deletingProduct.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Product deleted successfully!');
            showDeleteDialog.value = false;
            deletingProduct.value = undefined;
        },
        onError: () => {
            toast.error('Failed to delete product');
        },
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];

const getNumericLinks = () => {
    // Filtrar solo los links numéricos y elipsis, excluyendo Previous y Next
    return props.products.links.filter(link => {
        const label = link.label;
        return label !== '&laquo; Previous' &&
            label !== 'Next &raquo;' &&
            label !== 'Previous' &&
            label !== 'Next';
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto px-6 py-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Products</h1>
                <CreateProduct @product-created="handleProductCreated" />
            </div>

            <div class="overflow-hidden rounded-lg border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead class="text-right">Price</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="products.data.length > 0">
                            <TableRow v-for="product in products.data" :key="product.id">
                                <TableCell class="font-medium">{{ product.name }}</TableCell>
                                <TableCell>
                                    {{ product.description || '-' }}
                                </TableCell>
                                <TableCell class="text-right">
                                    ${{ product.price.toFixed(2) }}
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button size="sm" variant="outline" @click="editProduct(product)">
                                            <Pencil class="h-4 w-4" />
                                        </Button>
                                        <Button size="sm" variant="outline" @click="confirmDelete(product)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </template>
                        <TableRow v-else>
                            <TableCell colspan="4" class="text-center text-muted-foreground">
                                No products found. Create your first product to get started.
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <!-- Pagination -->
            <div v-if="products.total > 0" class="mt-6 flex items-center justify-between">
                <p class="text-sm text-muted-foreground">
                    Showing {{ products.from }} to {{ products.to }} of {{ products.total }} products
                </p>
                <div v-if="products.last_page > 1">
                    <Pagination>
                        <PaginationList>
                            <PaginationListItem>
                                <PaginationFirst :href="products.first_page_url"
                                    :disabled="products.current_page === 1" />
                            </PaginationListItem>
                            <PaginationListItem>
                                <PaginationPrev :href="products.prev_page_url ?? undefined"
                                    :disabled="!products.prev_page_url" />
                            </PaginationListItem>

                            <template v-for="(link, index) in getNumericLinks()" :key="index">
                                <PaginationListItem>
                                    <PaginationEllipsis v-if="link.label === '...'" />
                                    <PaginationLink v-else :href="link.url ?? undefined" :is-active="link.active"
                                        size="default">
                                        {{ link.label }}
                                    </PaginationLink>
                                </PaginationListItem>
                            </template>

                            <PaginationListItem>
                                <PaginationNext :href="products.next_page_url ?? undefined"
                                    :disabled="!products.next_page_url" />
                            </PaginationListItem>
                            <PaginationListItem>
                                <PaginationLast :href="products.last_page_url"
                                    :disabled="products.current_page === products.last_page" />
                            </PaginationListItem>
                        </PaginationList>
                    </Pagination>
                </div>
            </div>

            <!-- Edit Product Modal -->
            <EditProduct v-model="showEditModal" :product="editingProduct" @product-updated="handleProductUpdated" />

            <!-- Delete Confirmation Dialog -->
            <AlertDialog v-model:open="showDeleteDialog">
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                        <AlertDialogDescription>
                            This action cannot be undone. This will permanently delete the product
                            <span class="font-semibold">{{ deletingProduct?.name }}</span>.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction @click="deleteProduct">Delete</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </div>
    </AppLayout>
</template>