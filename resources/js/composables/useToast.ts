import { ref } from 'vue';

export interface Toast {
    id: number;
    message: string;
    type: 'success' | 'error' | 'info' | 'warning';
    duration?: number;
}

const toasts = ref<Toast[]>([]);
let nextId = 1;

export const useToast = () => {
    const show = (message: string, type: Toast['type'] = 'info', duration: number = 1000) => {
        const toast: Toast = {
            id: nextId++,
            message,
            type,
            duration,
        };

        toasts.value.push(toast);

        // Auto remove after duration
        setTimeout(() => {
            remove(toast.id);
        }, duration);
    };

    const remove = (id: number) => {
        const index = toasts.value.findIndex(t => t.id === id);
        if (index > -1) {
            toasts.value.splice(index, 1);
        }
    };

    const success = (message: string, duration?: number) => {
        show(message, 'success', duration);
    };

    const error = (message: string, duration?: number) => {
        show(message, 'error', duration || 3000); // Errors show longer by default
    };

    const info = (message: string, duration?: number) => {
        show(message, 'info', duration);
    };

    const warning = (message: string, duration?: number) => {
        show(message, 'warning', duration);
    };

    return {
        toasts,
        show,
        remove,
        success,
        error,
        info,
        warning,
    };
};