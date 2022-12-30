<template>
  <div class="w-full p-3  z-50 position-fixed bottom-0 right-0 left-0 text-center mb-2">
    <a v-if="service.meta.ticket" :href="'tel:' + service.meta.ticket" target="_blank" class="w-32 p-3 bg-theme-color mr-1">
      <i class="fas fa-shopping-cart"></i> Bilet
    </a>
    <a v-if="service.meta.mail" :href="'mailto:' + service.meta.mail" target="_blank" class="bg-theme-color p-3 mr-1">
      <i class="fas fa-envelope"></i> Mail
    </a>
    <a v-if="service.meta.phone" :href="'tel:' + service.meta.phone" class="bg-theme-color p-3 mr-1">
      <i class="fas fa-phone"></i> Ara
    </a>
  </div>
</template>

<script>
export default {
  name: "ServiceOptions",
  props: ['service'],

  mounted() {
    console.log(this.service);
  }
}
</script>
