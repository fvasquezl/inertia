<template>
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold text-gray-900">Users</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all the users.</p>
      </div>
      <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <button type="button"
          class=" flex rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
          <CirclePlus class="w-5 h-5 mr-2" />Add user
        </button>
      </div>
    </div>
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th scope="col" class="py-3.5 pr-3 pl-4 text-center text-sm font-semibold text-gray-900 sm:pl-0">
                  <a href="#" class="group inline-flex">
                    Id
                  </a>
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                  <a href="#" class="group inline-flex">
                    Title
                  </a>
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                  <a href="#" class="group inline-flex">
                    Email
                  </a>
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                  <a href="#" class="group inline-flex">
                    Role
                  </a>
                </th>
                <th scope="col" class="relative py-3.5 pr-0 pl-3">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="user in people" :key="user.id">
                <td class="py-4 pr-3 pl-4 text-sm text-center font-medium whitespace-nowrap text-gray-900 sm:pl-0">
                  {{ user.id }}</td>
                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{ user.name }}</td>
                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{ user.email }}</td>
                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500"></td>
                <td class="flex items-center justify-center py-4 px-3 text-sm whitespace-nowrap sm:pr-0">
                  <button @click="handleEdit(user.id)"
                    class="flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-500  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <FilePenLine class="w-5 h-5 mr-2" /> Edit
                  </button>
                  <a href="#"
                    class="flex items-center ml-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                    <Trash2Icon class="w-5 h-5 mr-2" /> Delete
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { CirclePlus, FilePenLine, Trash2Icon } from 'lucide-vue-next';
defineProps<{
  people: Array<{
    id: number;
    name: string;
    email: string;
  }>
}>();

const emit = defineEmits<{
    (e: 'edit-user', id: number): void;
}>();

function handleEdit(id: number) {
    emit('edit-user', id);
}

</script>
