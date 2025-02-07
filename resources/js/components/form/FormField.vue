<template>
    <div class="mb-3">
        <div class="mb-3">
            <label :for="name" class="form-label">{{ label }}</label>
            <Field :name="name" :type="type" class="form-control" :as="as"/>
            <ErrorMessage :name="name"  />
        </div>
    </div>
</template>



<script>
import { ErrorMessage, Field } from "vee-validate";

export default {
    components: {ErrorMessage, Field},
    props: {
        label: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
        as: {
            type: String,
            default: 'input',
        },
    },
};
</script>

<style scoped>
span[role="alert"] {
    color: #dc3545;
}
</style>
