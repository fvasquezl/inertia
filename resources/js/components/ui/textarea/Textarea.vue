<script setup lang="ts">
import { useVModel } from '@vueuse/core';
import { cn } from '@/lib/utils';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
    modelValue?: string | number;
    name?: string;
    id?: string;
    placeholder?: string;
    disabled?: boolean;
    readonly?: boolean;
    required?: boolean;
    autofocus?: boolean;
    autocomplete?: string;
    rows?: number;
    cols?: number;
    maxlength?: number;
}>();

const emits = defineEmits<{
    'update:modelValue': [value: string];
}>();

const modelValue = useVModel(props, 'modelValue', emits);

const textareaClass = computed(() =>
    cn(
        'flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
        props.class
    )
);
</script>

<template>
    <textarea
        v-model="modelValue"
        :class="textareaClass"
        :name="name"
        :id="id"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        :required="required"
        :autofocus="autofocus"
        :autocomplete="autocomplete"
        :rows="rows"
        :cols="cols"
        :maxlength="maxlength"
    />
</template>