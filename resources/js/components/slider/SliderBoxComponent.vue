<template>
  <div>
    <h2 class="text-xl my-3">{{ title }}</h2>
    <carousel :autoplay="true" :loop="true" :items="3" :responsive="{0:{items:1,nav:false},600:{items:3,nav:false}}" :autoplaySpeed="1400" :dots="false" :nav="false" :margin="5"
              class="w-full animate__animated animate__fadeIn shadow shadow-sm mb-10 h-60" v-if="rows.length > 0">
      <div class="w-full h-60 overflow-hidden relative" v-for="row in rows">
        <a :href="'/etkinlikler/' + row.slug">
          <img class="w-full h-60 object-cover"
               :alt="row.title"
               :src="'/storage/' + row.logo">

          <div class="z-10 bg-theme-color opacity-95 hover:opacity-100 p-2 absolute bottom-0 right-0 left-0">{{row.title}}
          </div>
        </a>
      </div>
    </carousel>
  </div>
</template>

<script>
import carousel from 'vue-owl-carousel'

export default {
  components: {carousel},
  props: {
    "title": String,
    "rows": Array
  },
  data() {
    return {
      sliders: this.rows
    }
  },

}
</script>
