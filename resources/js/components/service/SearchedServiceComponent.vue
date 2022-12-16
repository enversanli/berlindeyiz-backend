<template>
  <div>
    <div class="container">
      <search-box-component></search-box-component>
      <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 text-lg text-theme-color mt-1">
        <div
            class="h-9 m-3 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn"
            :class="[(all === true ? 'shadow-xl active-service' : '')]"
            @click="filterServices('all')">
          <p class="text-center font-weight-bold"><i class="far fa-check-circle"></i> Tümü</p>
        </div>
        <div
            class="h-9 m-3 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn"
            :class="[(priced === true ? 'shadow-xl active-service' : '')]"
            @click="filterServices('priced')">
          <p class="text-center font-weight-bold"><i class="far fa-check-circle"></i> Ücretli</p>
        </div>
        <div
            class="h-9  m-3 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn "
            :class="[(free === true ? 'shadow-xl active-service' : '')]"
            @click="filterServices('free')">
          <p class="text-center font-weight-bold"><i class="far fa-arrow-alt-circle-right"></i> Ücretsiz</p>
        </div>

      </div>
      <div v-show="services.count === 0"
           class="animate__animated animate__fadeIn m-3 p-1 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl relative overflow-hidden service-box pt-3">
        <p class="w-full text-2xl text-center my-10">Üzgünüz, Hiçbir Etkinlik Bulunamadı!</p>
      </div>
      <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1">
        <service-box-component :services="services"></service-box-component>
        <div class="grid lg:w-1/4 md:w-1/4 sm:1/4  p-3">
        </div>
      </div>

      <slider-box-component title="Son Eklenen Etkinlikler" :rows="this.lastAdded"></slider-box-component>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    category: String,
    type: String,
    date: String
  },
  data() {
    return {
      services: [],
      lastAdded: [],
      similar: [],
      links: '',
      loadMore: true,
      test: [],
      goBack: false,
      active: true,
      all: true,
      priced: false,
      free: false,
    }
  },

  mounted() {
    this.searchService();
    this.getLastAdded();
  },

  methods: {
    searchService() {
      var url = '/hizmet-ara?type='+ this.type + '&category=' + this.category +'&tarih=' + this.date;
      axios.post(url).then(response => {
        this.services = response.data.data;
        this.links = response.data.links;
        alert(services.count);
      })
    },

    filterServices(status = null) {
      this.free = false;
      this.priced = false;
      this.all = false;
      if (status === 'free') {
        this.free = true;
      } else if (status === 'priced') {
        this.priced = true;
      } else {
        this.all = true
      }

      var url = '/hizmet-ara?category=' + this.category + '&sehir=' + this.city + '&status=' + status;

      if (status === null) {
        url = '/hizmet-ara';
        this.goBack = false;
      }
      // if (status !== null && status === 'Ended') {
      //     this.goBack = true;
      // }
      axios.post(url).then(response => {
        this.services = response.data.data;
        this.links = response.data.links;
      })
    },

    load() {
      if (this.links.next === null) {
        this.loadMore = false;
        return false;
      }

      var nextUrl = this.links.next;

      if (this.free === true) {
        nextUrl = nextUrl + '&status=free'
      }

      if (this.priced === true) {
        nextUrl = nextUrl + '&status=priced'
      }

      if (this.all === true) {
        nextUrl = nextUrl + '&status=all'
      }

      axios.post(nextUrl).then(response => {
        //this.services = response.data.data;
        this.links = response.data.links;
        if (this.links.next === null) {
          this.loadMore = false;
        }
        var data = this.services;
        $.each(response.data.data, function (key, value) {
          data.push(value);
        });
        this.services = data;
      })
    },

    getLastAdded() {
      var url = '/etkinlikler/son-eklenenler';
      axios.get(url).then(response => {
        this.lastAdded = response.data.data;
      })
    },
    isMobile() {
      if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true
      } else {
        return false
      }
    }

  }
}
</script>
