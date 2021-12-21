<template>
  <div>
    <heading class="mb-6">{{ title }}</heading>
    <iframe
        :src="url"
        allowtransparency
    ></iframe>
  </div>
</template>

<script>
export default {
  props: ['identifier'],

  computed: {
    url() {
      return Nova.config[this.identifier].url;
    },

    title() {
      return Nova.config[this.identifier].title;
    },
  },
}
</script>

<style scoped>
iframe {
  width: 100%;
  min-height: 100vh;
}
</style>
