<script setup lang="ts">
import { ref, computed, nextTick } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import CreateProduct from '@/components/products/CreateProduct.vue';
import EditProduct from '@/components/products/EditProduct.vue';
import DeleteProduct from '@/components/products/DeleteProduct.vue';
import ShowProduct from '@/components/products/ShowProduct.vue';
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
    Dialog,
    DialogContent,
} from '@/components/ui/dialog';
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
import { Eye, Pencil, Trash2, X } from 'lucide-vue-next';
import SortIcon from '@/components/SortIcon.vue';

const props = defineProps<{
    products: PaginatedData<Product>;
    sort?: string;
    direction?: 'asc' | 'desc';
    search?: string;
}>();

const toast = useToast();
const editingProduct = ref<Product | undefined>();
const showEditModal = ref(false);
const deletingProduct = ref<Product | undefined>();
const showDeleteDialog = ref(false);
const viewingProduct = ref<Product | undefined>();
const showViewModal = ref(false);
const search = ref(props.search || '');
const loading = ref(false);
const searchInput = ref<HTMLInputElement | null>(null);

const sort = computed(() => props.sort || 'id');
const direction = computed(() => props.direction || 'asc');

const setSort = (column: string) => {
    let newDirection = 'asc';
    if (sort.value === column && direction.value === 'asc') {
        newDirection = 'desc';
    }
    router.get(route('products.index'), { sort: column, direction: newDirection }, { preserveScroll: true });
};

const onSearch = (e?: Event) => {
    if (e) e.preventDefault();
    loading.value = true;
    router.get(
        route('products.index'),
        { search: search.value, sort: sort.value, direction: direction.value },
        {
            preserveScroll: true,
            onFinish: () => {
                loading.value = false;
                setTimeout(() => {
                    searchInput.value?.focus();
                }, 0);
            },
        }
    );
};

const handleProductCreated = () => {
    toast.success('Product created successfully!');
    router.reload({ only: ['products'] });
};

const handleProductUpdated = () => {
    toast.success('Product updated successfully!');
    router.reload({ only: ['products'] });
};

const handleProductDeleted = () => {
    toast.success('Product deleted successfully!');
    showDeleteDialog.value = false;
    deletingProduct.value = undefined;
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

const viewProduct = (product: Product) => {
    viewingProduct.value = product;
    showViewModal.value = true;
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
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h1 class="text-2xl font-bold">Products</h1>
                <div class="flex flex-col sm:flex-row gap-2 items-center">
                    <div class="relative w-64">
                        <input ref="searchInput" v-model="search" @keyup.enter="onSearch" type="text"
                            placeholder="Search products..."
                            class="border rounded px-3 py-2 text-sm focus:outline-none focus:ring w-full pr-8" />
                        <button v-if="search"
                            @click="() => { search = ''; onSearch(); ((searchInput?.value as unknown) as HTMLInputElement | null)?.focus(); }"
                            type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <X class="w-4 h-4" />
                        </button>
                    </div>
                    <Button variant="default" @click="onSearch">Search</Button>
                    <CreateProduct @product-created="handleProductCreated" />
                </div>
            </div>

            <div class="overflow-hidden rounded-lg border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead @click="setSort('id')" class="cursor-pointer select-none">
                                Id
                                <SortIcon sort-key="id" :direction="direction" :active-sort="sort" />
                            </TableHead>
                            <TableHead>Image</TableHead>
                            <TableHead @click="setSort('name')" class="cursor-pointer select-none">
                                Name
                                <SortIcon sort-key="name" :direction="direction" :active-sort="sort" />
                            </TableHead>
                            <TableHead @click="setSort('description')" class="cursor-pointer select-none">
                                Description
                                <SortIcon sort-key="description" :direction="direction" :active-sort="sort" />
                            </TableHead>
                            <TableHead @click="setSort('price')" class="cursor-pointer select-none text-right">
                                Price
                                <SortIcon sort-key="price" :direction="direction" :active-sort="sort" />
                            </TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="products.data.length > 0">
                            <TableRow v-for="product in products.data" :key="product.id">
                                <TableCell>{{ product.id }}</TableCell>
                                <TableCell>
                                    <img v-if="product.image" :src="`/storage/${product.image}`" :alt="product.name"
                                        class="w-12 h-12 object-cover rounded" />
                                    <span v-else class="text-xs text-muted-foreground">No image</span>
                                </TableCell>
                                <TableCell class="font-medium">{{ product.name }}</TableCell>
                                <TableCell>
                                    {{ product.description || '-' }}
                                </TableCell>
                                <TableCell class="text-right">
                                    ${{ product.price.toFixed(2) }}
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button size="sm" variant="outline" @click="() => viewProduct(product)">
                                            <Eye class="h-4 w-4" />
                                        </Button>
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
                            <TableCell colspan="6" class="text-center text-muted-foreground">
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
            <DeleteProduct :open="showDeleteDialog" :product="deletingProduct" @update:open="showDeleteDialog = $event"
                @product-deleted="handleProductDeleted" />

            <!-- View Product Modal -->
            <Dialog v-model:open="showViewModal">
                <DialogContent>
                    <ShowProduct v-if="viewingProduct" :product="viewingProduct" />
                </DialogContent>
            </Dialog>
        </div>
    </AppLayout>
</template>