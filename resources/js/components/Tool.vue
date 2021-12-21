<template>
    <div>
        <heading class="mb-6">{{ title }}</heading>
        <iframe
            :src="iframeUrl"
            frameborder="0"
            style="width: 100%; min-height: 100vh;"
            allowtransparency
        ></iframe>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            iframeUrl: '',
        };
    },

    beforeMount() {
        this.fetchIframeUrl();
    },

    computed: {
        title: function () {
            return Nova.config.kpiDashboard.title;
        }
    },

    methods: {
        fetchIframeUrl: function () {
            Nova.request().get('/nova-vendor/kpi-dashboard/')
                .then(response => {
                    this.iframeUrl = response.data.data.iframeUrl;
                })
        }
    }
}
</script>

<style>
/* Scoped Styles */
</style>
