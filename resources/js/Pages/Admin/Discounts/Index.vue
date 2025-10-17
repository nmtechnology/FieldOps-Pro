<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    discounts: Object,
});

const showingModal = ref(false);
const modalMode = ref('create'); // 'create' or 'edit'
const selectedDiscount = ref(null);
const form = ref({
    code: '',
    description: '',
    amount: '',
    type: 'percentage', // 'percentage' or 'fixed'
    active: true,
    expires_at: '',
});

const errors = ref({});

const openCreateModal = () => {
    modalMode.value = 'create';
    form.value = {
        code: '',
        description: '',
        amount: '',
        type: 'percentage',
        active: true,
        expires_at: '',
    };
    errors.value = {};
    showingModal.value = true;
};

const openEditModal = (discount) => {
    modalMode.value = 'edit';
    selectedDiscount.value = discount;
    form.value = {
        code: discount.code,
        description: discount.description || '',
        amount: discount.amount,
        type: discount.type || 'percentage',
        active: discount.active,
        expires_at: discount.expires_at || '',
    };
    errors.value = {};
    showingModal.value = true;
};

const closeModal = () => {
    showingModal.value = false;
};

const submitForm = () => {
    if (modalMode.value === 'create') {
        router.post('/admin/discounts', form.value, {
            onSuccess: () => {
                closeModal();
            },
            onError: (err) => {
                errors.value = err;
            },
        });
    } else {
        router.put(`/admin/discounts/${selectedDiscount.value.id}`, form.value, {
            onSuccess: () => {
                closeModal();
            },
            onError: (err) => {
                errors.value = err;
            },
        });
    }
};

const confirmDelete = (discount) => {
    if (confirm(`Are you sure you want to delete discount code ${discount.code}?`)) {
        router.delete(`/admin/discounts/${discount.id}`);
    }
};

const formatDate = (dateString) => {
    if (!dateString) return 'No expiration';
    return new Date(dateString).toLocaleDateString();
};

const formatAmount = (amount, type) => {
    if (type === 'percentage') {
        return `${amount}%`;
    }
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
};
</script>

<template>
    <Head title="Discount Codes Management" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Discount Codes</h2>
                <button
                    @click="openCreateModal"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                >
                    Add New Discount
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="discount in discounts.data" :key="discount.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ discount.code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ discount.description || '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatAmount(discount.amount, discount.type) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span 
                                                :class="[
                                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                    discount.active 
                                                        ? 'bg-green-100 text-green-800' 
                                                        : 'bg-gray-100 text-gray-800'
                                                ]"
                                            >
                                                {{ discount.active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(discount.expires_at) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                                            <button
                                                @click="openEditModal(discount)"
                                                class="text-indigo-600 hover:text-indigo-900 px-2 py-1"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                @click="confirmDelete(discount)"
                                                class="text-red-600 hover:text-red-900 px-2 py-1"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="discounts.data && discounts.data.length === 0">
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No discount codes found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-4 flex justify-between" v-if="discounts.data && discounts.data.length > 0">
                            <div v-if="discounts.prev_page_url" class="flex items-center">
                                <Link :href="discounts.prev_page_url" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Previous
                                </Link>
                            </div>
                            <div class="text-sm text-gray-700 py-2">
                                Showing {{ discounts.from }} to {{ discounts.to }} of {{ discounts.total }} discounts
                            </div>
                            <div v-if="discounts.next_page_url" class="flex items-center">
                                <Link :href="discounts.next_page_url" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Next
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <Modal :show="showingModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ modalMode === 'create' ? 'Add New Discount Code' : 'Edit Discount Code' }}
                </h2>

                <form @submit.prevent="submitForm" class="mt-6 space-y-6">
                    <div>
                        <InputLabel for="code" value="Discount Code" />
                        <TextInput
                            id="code"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.code"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="errors.code" />
                    </div>

                    <div>
                        <InputLabel for="description" value="Description (Optional)" />
                        <TextInput
                            id="description"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.description"
                        />
                        <InputError class="mt-2" :message="errors.description" />
                    </div>

                    <div>
                        <InputLabel for="amount" value="Amount" />
                        <TextInput
                            id="amount"
                            type="number"
                            step="0.01"
                            min="0"
                            class="mt-1 block w-full"
                            v-model="form.amount"
                            required
                        />
                        <InputError class="mt-2" :message="errors.amount" />
                    </div>

                    <div>
                        <InputLabel for="type" value="Type" />
                        <select
                            id="type"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.type"
                            required
                        >
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount ($)</option>
                        </select>
                        <InputError class="mt-2" :message="errors.type" />
                    </div>

                    <div>
                        <InputLabel for="expires_at" value="Expiration Date (Optional)" />
                        <TextInput
                            id="expires_at"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.expires_at"
                        />
                        <InputError class="mt-2" :message="errors.expires_at" />
                    </div>

                    <div class="flex items-center mt-4">
                        <input
                            id="active"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            v-model="form.active"
                        />
                        <InputLabel for="active" value="Active" class="ml-2" />
                        <InputError class="mt-2" :message="errors.active" />
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-4">
                        <SecondaryButton type="button" @click="closeModal">
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton class="ml-4" :disabled="false">
                            {{ modalMode === 'create' ? 'Create Discount' : 'Update Discount' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>