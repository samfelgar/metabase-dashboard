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
      if (typeof Nova.appConfig[this.identifier] === 'undefined') {
        Nova.visit('/403');
      }
      return Nova.appConfig[this.identifier].url;
    },

    title() {
      if (typeof Nova.appConfig[this.identifier] === 'undefined') {
        Nova.visit('/403');
      }
      return Nova.appConfig[this.identifier].title;
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
