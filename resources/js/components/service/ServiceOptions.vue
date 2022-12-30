<template>
  <div class="w-auto mr-auto ml-auto p-3  z-50 position-fixed bottom-2 right-3 left-3 text-center">
    <a v-if="service.meta.ticket" :href="'tel:' + service.meta.ticket" target="_blank" class="w-32 p-3 shadow-lg bg-theme-color mr-1">
      <i class="fas fa-shopping-cart"></i> Bilet Al
    </a>
    <a v-if="service.meta.mail" :href="'mailto:' + service.meta.mail" target="_blank" class="bg-theme-color p-3 mr-1">
      <i class="fas fa-envelope"></i> Mail Gönder
    </a>
    <a v-if="service.meta.phone" :href="'tel:' + service.meta.phone" class="bg-theme-color p-3 mr-1">
      <i class="fas fa-phone"></i> Bilgi Al
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
