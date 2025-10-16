<template>
    <AppLayout title="Discount Management">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Discount Code Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Flash Messages -->
                        <div v-if="$page.props.flash.success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ $page.props.flash.success }}
                        </div>
                        <div v-if="$page.props.flash.error" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ $page.props.flash.error }}
                        </div>
                        
                        <!-- Create New Discount -->
                        <div class="mb-8">
                            <button @click="openCreateModal" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create New Discount Code
                            </button>
                        </div>
                        
                        <!-- Discounts Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Code
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type / Value
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Usage
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Validity
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="discount in discounts" :key="discount.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ discount.code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ discount.type === 'percentage' ? discount.value + '%' : '$' + discount.value.toFixed(2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span v-if="discount.is_active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                            <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Inactive
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ discount.usage_count || 0 }} / {{ discount.max_uses || '∞' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div v-if="discount.valid_from || discount.valid_until">
                                                <span v-if="discount.valid_from">From: {{ discount.valid_from }}</span>
                                                <span v-if="discount.valid_from && discount.valid_until"><br></span>
                                                <span v-if="discount.valid_until">Until: {{ discount.valid_until }}</span>
                                            </div>
                                            <div v-else>No expiration</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button @click="editDiscount(discount)" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                Edit
                                            </button>
                                            <button @click="deleteDiscount(discount)" class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="discounts.length === 0">
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No discount codes found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Discount Form Modal -->
        <div v-if="showDiscountModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="saveDiscount">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ isEditMode ? 'Edit Discount Code' : 'Create New Discount Code' }}
                                </h3>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-y-4">
                                <div>
                                    <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="code" id="code" v-model="form.code" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" placeholder="Enter code or leave blank to generate">
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Leave blank to generate a random code</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Type</label>
                                    <div class="mt-1 flex items-center">
                                        <div class="mr-4">
                                            <input id="type-percentage" type="radio" v-model="form.type" value="percentage" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            <label for="type-percentage" class="ml-1 text-sm font-medium text-gray-700">Percentage (%)</label>
                                        </div>
                                        <div>
                                            <input id="type-fixed" type="radio" v-model="form.type" value="fixed" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            <label for="type-fixed" class="ml-1 text-sm font-medium text-gray-700">Fixed Amount ($)</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                            {{ form.type === 'percentage' ? '%' : '$' }}
                                        </span>
                                        <input type="number" step="0.01" min="0" name="value" id="value" v-model="form.value" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-r-md sm:text-sm border-gray-300">
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex items-center">
                                        <input id="is_active" type="checkbox" v-model="form.is_active" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="valid_from" class="block text-sm font-medium text-gray-700">Valid From (optional)</label>
                                    <div class="mt-1">
                                        <input type="date" name="valid_from" id="valid_from" v-model="form.valid_from" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-md sm:text-sm border-gray-300">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="valid_until" class="block text-sm font-medium text-gray-700">Valid Until (optional)</label>
                                    <div class="mt-1">
                                        <input type="date" name="valid_until" id="valid_until" v-model="form.valid_until" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-md sm:text-sm border-gray-300">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="max_uses" class="block text-sm font-medium text-gray-700">Max Uses (optional)</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="number" min="1" step="1" name="max_uses" id="max_uses" v-model="form.max_uses" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" placeholder="Leave blank for unlimited">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description (optional)</label>
                                    <div class="mt-1">
                                        <textarea id="description" name="description" v-model="form.description" rows="2" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-md sm:text-sm border-gray-300"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ isEditMode ? 'Update' : 'Create' }}
                            </button>
                            <button @click="closeDiscountModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Delete Discount Code
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this discount code? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                        <button @click="closeDeleteModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AppLayout from '@/Layouts/AppLayout.vue';

export default defineComponent({
    components: {
        AppLayout
    },
    props: {
        discounts: Array
    },
    data() {
        return {
            showDiscountModal: false,
            showDeleteModal: false,
            isEditMode: false,
            selectedDiscount: null,
            form: {
                code: '',
                type: 'percentage',
                value: '',
                is_active: true,
                valid_from: null,
                valid_until: null,
                max_uses: null,
                description: ''
            }
        };
    },
    methods: {
        openCreateModal() {
            this.isEditMode = false;
            this.resetForm();
            this.showDiscountModal = true;
        },
        editDiscount(discount) {
            this.isEditMode = true;
            this.selectedDiscount = discount;
            this.form = {
                code: discount.code,
                type: discount.type,
                value: discount.value,
                is_active: discount.is_active,
                valid_from: discount.valid_from,
                valid_until: discount.valid_until,
                max_uses: discount.max_uses,
                description: discount.description
            };
            this.showDiscountModal = true;
        },
        closeDiscountModal() {
            this.showDiscountModal = false;
            this.resetForm();
        },
        resetForm() {
            this.form = {
                code: '',
                type: 'percentage',
                value: '',
                is_active: true,
                valid_from: null,
                valid_until: null,
                max_uses: null,
                description: ''
            };
            this.selectedDiscount = null;
        },
        saveDiscount() {
            if (this.isEditMode) {
                Inertia.put(route('admin.discounts.update', this.selectedDiscount.id), this.form, {
                    onSuccess: () => {
                        this.closeDiscountModal();
                    }
                });
            } else {
                Inertia.post(route('admin.discounts.store'), this.form, {
                    onSuccess: () => {
                        this.closeDiscountModal();
                    }
                });
            }
        },
        deleteDiscount(discount) {
            this.selectedDiscount = discount;
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
            this.selectedDiscount = null;
        },
        confirmDelete() {
            Inertia.delete(route('admin.discounts.destroy', this.selectedDiscount.id), {
                onSuccess: () => {
                    this.closeDeleteModal();
                }
            });
        }
    }
});
</script>