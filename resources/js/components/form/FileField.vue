<template>
    <div class="mb-3">
        <label :for="name" class="form-label">{{ label }}</label>
        <Field
            :name="name"
            v-slot="{ field, meta }"
        >
            <input
                type="file"
                class="form-control"
                :id="name"
                v-bind="field"
                :accept="accept"
                :multiple="multiple"
                @change="handleFileChange"
            />
        </Field>
        <ErrorMessage :name="name" class="invalid-feedback d-block" />
    </div>
</template>

<script>
import { Field, ErrorMessage } from "vee-validate";

export default {
    components: {Field, ErrorMessage},
    props: {
        label: {type: String, required: true},
        name: {type: String, required: true},
        accept: {type: String, default: ""},
        multiple: {type: Boolean, default: false}
    },
    methods: {
        handleFileChange(event) {
            const files = event.target.files;
            this.$emit("update:modelValue", this.multiple ? [...files] : files[0]);
        }
    }
};
</script>

<style scoped>
.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>
