<template>

  <div class="w-full">
    <div v-for="business in businesses">
      <p>{{business.title}}</p>
    </div>
  </div>

</template>

<script>
export default {
  data() {
    return {
      businesses: null,
    }
  },


  methods:{
    getBusinesses(){
      axios.get('/businesses').then(response => {
        this.businesses = response.data.data;
      });
    }
  }
}
</script>

<style scoped>



</style>