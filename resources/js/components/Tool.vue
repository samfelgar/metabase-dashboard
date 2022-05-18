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
      if (typeof Nova.config[this.identifier] === 'undefined'){
        this.$router.push('/403')
      }
      return Nova.config[this.identifier].url;
    },

    title() {
      if (typeof Nova.config[this.identifier] === 'undefined'){
        this.$router.push('/403')
      }
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
