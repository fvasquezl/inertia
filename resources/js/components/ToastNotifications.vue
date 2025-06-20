<script setup lang="ts">
import { useToast } from '@/composables/useToast';
import { CheckCircle2, XCircle, Info, AlertTriangle, X } from 'lucide-vue-next';
import { TransitionGroup } from 'vue';

const { toasts, remove } = useToast();

const icons = {
    success: CheckCircle2,
    error: XCircle,
    info: Info,
    warning: AlertTriangle,
};

const colors = {
    success: 'bg-green-50 text-green-800 border-green-200',
    error: 'bg-red-50 text-red-800 border-red-200',
    info: 'bg-blue-50 text-blue-800 border-blue-200',
    warning: 'bg-yellow-50 text-yellow-800 border-yellow-200',
};
</script>

<template>
    <div class="fixed top-4 right-4 z-50 space-y-2">
        <TransitionGroup name="toast" tag="div" v-bind="$attrs">
            <template v-for="toast in toasts" :key="toast.id">
                <div :class="[
                    'flex items-center gap-3 px-4 py-3 rounded-lg border shadow-lg min-w-[300px] max-w-md',
                    colors[toast.type]
                ]">
                    <component :is="icons[toast.type]" class="h-5 w-5 flex-shrink-0" />
                    <p class="flex-1 text-sm font-medium">{{ toast.message }}</p>
                    <button @click="remove(toast.id)" class="flex-shrink-0 ml-2 hover:opacity-70 transition-opacity">
                        <X class="h-4 w-4" />
                    </button>
                </div>
            </template>
        </TransitionGroup>
    </div>
</template>

<style scoped>
.toast-enter-active,
.toast-leave-active {
    transition: all 0.3s ease;
}

.toast-enter-from {
    transform: translateX(100%);
    opacity: 0;
}

.toast-leave-to {
    transform: translateX(100%);
    opacity: 0;
}

.toast-move {
    transition: transform 0.3s ease;
}
</style>