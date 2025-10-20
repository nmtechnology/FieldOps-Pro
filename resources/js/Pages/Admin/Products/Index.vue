<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    products: Object,
});

const showingDeleteModal = ref(false);
const productToDelete = ref(null);

const openDeleteModal = (product) => {
    productToDelete.value = product;
    showingDeleteModal.value = true;
};

const closeDeleteModal = () => {
    productToDelete.value = null;
    showingDeleteModal.value = false;
};

const deleteProduct = () => {
    router.delete(`/admin/products/${productToDelete.value.id}`, {
        onSuccess: () => {
            closeDeleteModal();
        },
    });
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString();
};
</script>

<template>
    <Head title="Products Management" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">Products Management</h2>
                <Link 
                    href="/admin/products/create"
                    class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-500 transition"
                >
                    Add New Product
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">ID</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Name</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Price</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Orders</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Created</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700 bg-gray-800">
                                    <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-700">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-6">{{ product.id }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-white">{{ product.name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ formatCurrency(product.price) }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <span 
                                                :class="[
                                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                    product.active 
                                                        ? 'bg-green-100 text-green-800' 
                                                        : 'bg-gray-100 text-gray-800'
                                                ]"
                                            >
                                                {{ product.active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ product.orders_count }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ formatDate(product.created_at) }}</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <div class="flex justify-end space-x-2">
                                                <Link 
                                                    :href="`/admin/products/${product.id}`" 
                                                    class="text-blue-400 hover:text-blue-300"
                                                    title="View"
                                                >
                                                    View
                                                </Link>
                                                <Link 
                                                    :href="`/admin/products/${product.id}/edit`" 
                                                    class="text-orange-400 hover:text-orange-300"
                                                    title="Edit"
                                                >
                                                    Edit
                                                </Link>
                                                <button 
                                                    @click="openDeleteModal(product)" 
                                                    class="text-red-400 hover:text-red-300"
                                                    title="Delete"
                                                    :disabled="product.orders_count > 0"
                                                    :class="{'opacity-50 cursor-not-allowed': product.orders_count > 0}"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="products.data.length === 0">
                                        <td colspan="7" class="py-10 text-center text-gray-400">
                                            No products found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-6 flex items-center justify-between border-t border-gray-700 pt-4">
                            <div v-if="products.prev_page_url" class="flex items-center">
                                <Link :href="products.prev_page_url" class="relative inline-flex items-center rounded-md border border-gray-700 bg-gray-800 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-700">
                                    Previous
                                </Link>
                            </div>
                            <div class="text-sm text-gray-400 py-2">
                                Showing {{ products.from }} to {{ products.to }} of {{ products.total }} products
                            </div>
                            <div v-if="products.next_page_url" class="flex items-center">
                                <Link :href="products.next_page_url" class="relative inline-flex items-center rounded-md border border-gray-700 bg-gray-800 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-700">
                                    Next
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <Modal :show="showingDeleteModal" @close="closeDeleteModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Delete Product
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Are you sure you want to delete this product? This action cannot be undone.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeDeleteModal" class="mr-3">
                        Cancel
                    </SecondaryButton>

                    <DangerButton @click="deleteProduct" class="ml-3">
                        Delete Product
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>