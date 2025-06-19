<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { cn } from '@/lib/utils';
import { buttonVariants } from '@/components/ui/button';
import type { Component } from 'vue';

interface Props {
    href?: string;
    isActive?: boolean;
    disabled?: boolean;
    class?: string;
    size?: 'default' | 'sm' | 'lg' | 'icon';
    as?: string | Component;
}

const props = withDefaults(defineProps<Props>(), {
    isActive: false,
    disabled: false,
    class: '',
    size: 'icon',
    as: 'button',
});
</script>

<template>
    <Link
        v-if="href && !disabled"
        :href="href"
        :class="
            cn(
                buttonVariants({
                    variant: isActive ? 'outline' : 'ghost',
                    size,
                }),
                props.class
            )
        "
        preserve-scroll
    >
        <slot />
    </Link>
    <component
        v-else
        :is="as"
        :disabled="disabled"
        :class="
            cn(
                buttonVariants({
                    variant: isActive ? 'outline' : 'ghost',
                    size,
                }),
                disabled && 'cursor-not-allowed opacity-50',
                props.class
            )
        "
    >
        <slot />
    </component>
</template>