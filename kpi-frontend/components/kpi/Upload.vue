<template>
    <b-card class="mt-3">
        <!-- Styled -->
        <b-form-file v-model="file" :state="Boolean(file)" placeholder="Choose a JSON file or drop it here..."
            drop-placeholder="Drop file here..."></b-form-file>
        <div class="mt-3">Selected file: {{ file ? file.name : '' }}</div>

        <div v-if="uploadPercentage">
            {{ uploadPercentage }}%
            <Spinner class="pb-3 px-2 d-inline text-right" />
            <progress class="d-block w-100" max="100" :value.prop="uploadPercentage"></progress>
        </div>

        <span class="text-danger d-block">{{ error }}</span>

        <b-button :disabled="error !== '' || loading || file === null" type="button" v-on:click="onSubmitHandler"
            class="my-3" variant="primary">
            Upload
        </b-button>
        <b-button :disabled="checkStatus" type="button" v-on:click="statusHandler" class="my-3" variant="info">
            Check Progress
        </b-button>

    </b-card>
</template>

<script>
export default {
    data() {
        return {
            file: null,
            loading: false,
            error: '',
            uploadPercentage: 0,
            checkStatus: true,
        }
    },
    updated() {
        this.file?.type !== 'application/json' && this.file !== null ? this.error = 'File must be of Json type' : this.error = '';
    },
    methods: {
        resetState() {
            this.uploadPercentage = 0;
            this.loading = false;
            this.file = null;
            this.error = '';
        },

        async onSubmitHandler(event) {
            event.preventDefault();

            this.loading = true;

            let formData = new FormData();
            formData.append('file', this.file);

            await this.$axios.post('/kpi',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function (progressEvent) {
                        this.uploadPercentage = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100));
                    }.bind(this)
                }
            ).then((res) => {
                this.$toast.success(res.data.message);
                this.checkStatus = false;
                console.log(res);
                this.resetState();
                // this.$toast.success(res.data?.success?.length + ' Records Inserted');
                // this.$toast.success(res.data?.failed?.length + ' Records Failed');
            }).catch((err) => {
                this.$toast.error(err?.response?.data[0]);
                console.log(err.response);
                this.resetState();
            });
        },

        async statusHandler() {
            await this.$axios.get('/kpi/status').then((res) => {
                this.$toast.success(res?.data?.message);
                this.$toast.success(res?.data?.failed);
                this.checkStatus = parseInt(res?.data?.count) === 0 ? true : false;
            }).catch((err) => {
                this.$toast.error(err?.response?.statusText);
            });
        }
    }
}
</script>