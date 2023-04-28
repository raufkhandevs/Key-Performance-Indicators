<template>
    <div>
        <Spinner class="text-center" v-if="loading" />
        <b-form v-else @submit="onSubmit" @reset="onReset" class="rounded">
            <b-form-group id="input-group-1" label="Email address:" label-for="input-1"
                description="We'll never share your email with anyone else.">
                <b-form-input id="input-1" v-model="form.email" type="email" placeholder="Enter email">
                </b-form-input>
                <span class="text-danger">{{ errors?.email ? errors?.email[0] : '' }}</span>
            </b-form-group>

            <b-form-group id="input-group-2" label="Year:" label-for="input-2">
                <b-form-input id="input-2" type="number" v-model="form.year" placeholder="Enter year">
                </b-form-input>
                <span class="text-danger">{{ errors?.year ? errors?.year[0] : '' }}</span>
            </b-form-group>

            <b-form-group id="input-group-2" label="Month:" label-for="input-2">
                <b-form-input id="input-2" type="number" v-model="form.month" placeholder="Enter month">
                </b-form-input>
                <span class="text-danger">{{ errors?.month ? errors?.month[0] : '' }}</span>
            </b-form-group>

            <b-form-group id="input-group-2" label="Value:" label-for="input-2">
                <b-form-input id="input-2" type="number" v-model="form.value" placeholder="Enter value">
                </b-form-input>
                <span class="text-danger">{{ errors?.value ? errors?.value[0] : '' }}</span>
            </b-form-group>

            <b-form-group id="input-group-3" label="Type:" label-for="input-3">
                <b-form-select id="input-3" v-model="form.type" :options="types"></b-form-select>
                <span class="text-danger">{{ errors?.type ? errors?.type[0] : '' }}</span>
            </b-form-group>

            <b-form-group id="input-group-3" label="Subtype:" label-for="input-3">
                <b-form-select id="input-3" v-model="form.subtype" :options="subtypes"></b-form-select>
                <span class="text-danger">{{ errors?.subtype ? errors?.subtype[0] : '' }}</span>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: '',
                year: '',
                month: '',
                value: '',
                type: null,
                subtype: null,
            },
            loading: false,
            errors: {},
            types: [{ text: 'Select One', value: null }, 'Individual', 'Team'],
            subtypes: [{ text: 'Select One', value: null }, 'Hourly', 'Weekly', 'Monthly'],
        }
    },
    methods: {
        async onSubmit(event) {
            event.preventDefault();

            this.loading = true;

            this.errors = {};

            await this.$axios.post('/kpi/legacy', this.form, { progress: true }).then((res) => {
                this.$toast.success(res.data.message);
                this.loading = false;
                onReset(event);
            }).catch((err) => {
                this.loading = false;
                this.$toast.error(err?.response?.data?.message);
                this.errors = err?.response?.data?.errors ? err?.response?.data?.errors : {};
            })

        },
        onReset(event) {
            event.preventDefault()
            this.errors = {};
            // Reset our form values
            this.form.email = '';
            this.form.year = '';
            this.form.month = '';
            this.form.value = '';
            this.form.type = null;
            this.form.subtype = null;
        }
    }
}
</script>