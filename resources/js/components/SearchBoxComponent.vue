<template>
  <div>
    <form action="/hizmet-ara">
      <h1 clasS="text-center text-3xl mb-2">Berlindeyiz.de</h1>
      <h2 clasS="text-center text-xl">Aradığın Her Şey Berlindeyiz.de!</h2>
      <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 text-lg text-theme-color w-2/3 mx-auto">


        <select name="type"
                @change="getCategories"
                v-model="type"
                class="h-9 m-1 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn border border-none">
          <option value="">Ne Arıyorsun ?</option>
          <option v-for="serviceType in serviceTypes" :value="serviceType.slug">{{ serviceType.title }}</option>
        </select>
        <select name="category"
                class="h-9 m-1 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn border border-none">
          <option value="">Kategori</option>
          <option v-for="category in categories" :value="category.slug">{{ category.name }}</option>
        </select>
        <!--<select name="sehir"
                class="h-9 m-1 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn">
          <option value="">Şehir</option>
          <option v-for="city in cities" :value="city.slug">{{ city.name }}</option>
        </select>-->
        <select
            @change="selectDate($event)"
            name="date"
            class="h-9  m-1 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn border border-none">
          <option :value="''">Tarih</option>
          <option :value="'bu-hafta'">Bu Hafta</option>
          <option :value="'gelecek-hafta'">Gelecek Hafta</option>
          <option :value="'bu-ay'">Bu Ay</option>
          <option :value="'gelecek-ay'">Gelecek Ay</option>
          <option @click="selectDate()" :value="true">Tarih Belirle</option>
        </select>
        <button type="submit"
                class="h-9  m-1 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn ">
          Ara
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      date: null,
      serviceTypes: null,
      type: '',
      categories: null,
      cities: null,
      dateSelectOption: true
    }
  },

  mounted() {
    //this.getCities();
    this.getCategories();
    this.getServiceTypes();
  },

  methods: {
    getCategories() {
      var endPoint = '/categories';

      if (this.type !== ''){
        endPoint += '?type=' + this.type;
      }

      axios.get(endPoint).then(response => {
        this.categories = response.data.data;
      });
    },

    getServiceTypes() {
      axios.get('/service-types').then(response => {
        this.serviceTypes = response.data.data;
      });
    },
    getCities() {
      axios.get('/cities').then(response => {
        this.cities = response.data.data;
      })
    },

    selectDate($event) {
      if ($event.target.value === true) {
        alert("DATE SELECT");
      }

    }
  }
}
</script>
