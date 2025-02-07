<template>
    <Form @submit="submitForm" class="container-md w-50" :validation-schema="schema">
        <div class="row">
            <div class="col-md-6">
                <FormField
                    label="Name"
                    name="name"/>
            </div>
            <div class="col-md-6">
                <FormField
                    label="Email"
                    name="email"
                    type="email"/>
            </div>
            <div class="col-md-6">
                <FormField
                    label="Phone"
                    name="phone"
                    type="tel"/>
            </div>
            <div class="col-md-6">
                <FormField
                    label="Message"
                    name="message"
                    as="textarea"/>
            </div>
            <div class="col-md-6">
                <FormField
                    label="Street"
                    name="street"/>
            </div>
            <div class="col-md-6">
                <FormField
                    label="State"
                    name="state"/>
            </div>
            <div class="col-md-6">
                <FormField
                    label="ZIP"
                    name="zip"/>
            </div>
            <div class="col-md-6">
                <FormField
                    label="Country"
                    name="country"/>
            </div>
            <div class="col-md-6">
                <FileField
                    label="Images"
                    name="images"
                    accept="image/jpeg"
                    :multiple="true"/>
            </div>
            <div class="col-md-6">
                <FileField
                    label="Files"
                    name="files"
                    accept="application/pdf"
                    :multiple="true"/>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-outline-success">Submit</button>
            </div>
        </div>
    </Form>
</template>


<script>
import { defineComponent, ref } from "vue";
import { ErrorMessage, Form, Field, useForm } from "vee-validate";
import * as yup from "yup";
import FormField from "./form/FormField.vue";
import FileField from "./form/FileField.vue";
import { useToast } from "vue-toastification";

export default defineComponent({
    components: {FormField, FileField, ErrorMessage, Form, Field},
    setup() {
        const toast = useToast();

        const schema = yup.object({
            name: yup.string().required(),
            email: yup.string().required().email(),
            phone: yup.string().required(),
            message: yup.string().required().min(20),
            street: yup.string().required(),
            state: yup.string().required(),
            zip: yup.number().required(),
            country: yup.string().required(),
            images: yup
                .mixed()
                .test("fileType", "Only JPG images allowed", (value) =>
                    value ? value.every((file) => file.type === "image/jpeg") : true
                ),
            files: yup
                .mixed()
                .test("fileType", "Only PDF files allowed", (value) =>
                    value ? value.every((file) => file.type === "application/pdf") : true
                ),
        });

        const submitForm = (values, { resetForm }) => {
            const formData = new FormData();

            for (const key in values) {
                if (values.hasOwnProperty(key) && !['images', 'files'].includes(key)) {
                    formData.append(key, values[key]);
                }
            }

            const images = values.images || [];
            const files = values.files || [];

            if (images) {
                images.forEach((image) => {
                    formData.append('images[]', image);
                });
            }

            if (files) {
                files.forEach((file) => {
                    formData.append('files[]', file);
                });
            }

            fetch('/submission', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'accept': 'application/json'
                },
            })
                .then((response) => {
                    if (response.ok) {
                        toast.success("Form submitted successfully!");
                        resetForm();
                    } else {
                        toast.error("Failed to submit the form.");
                    }
                })
                .catch((error) => {
                    alert('Error: ' + error.message);
                });
        };


        return {schema, submitForm};
    },
});
</script>
