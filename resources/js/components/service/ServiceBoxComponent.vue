<template>
  <div>
    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 mb-28">
      <a :href="service.type.slug + '/' + service.slug" v-for="service in services"
         class="animate__animated animate__fadeIn">
        <div
            class="h-94 m-3 p-1 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl relative overflow-hidden service-box pt-3">
          <div class="h-8 w-40  transform -right-12 top-5 rotate-45 z-1 absolute"
               v-if="service.type.slug === 'etkinlikler'"
               :class="[(service.is_priced === 1 ? 'bg-red-500' : 'bg-green-500')] "
          >
            <p class="text-white  mt-2 text-center">{{ service.is_priced === 1 ? 'Ücretli' : 'Ücretsiz' }}</p>
          </div>

          <div class="h-auto">
            <div class="w-full">
              <img class="h-64 xl:80 lg:h-72 md:h-64 sm:h-64 w-full px-3"
                   :alt="service.title"
                   :src="'/storage/'+service.logo">
              <div class="w-full z-10 p-2 bg-red-600 text-center text-white"
                   v-show="service.status === 'OUT_OF_DATE' || service.status === 'CANCELED'">
                <p>{{ service.status === 'CANCELED' ? 'Etkinlik İptal Edildi' : 'Etkinlik Sona Erdi' }}</p>
              </div>
              <div class="w-full z-10 p-2 bg-theme-color text-center text-white"
                   v-show="service.status === 'SPONSORED'">
                  <p>Sponsorlu</p>
              </div>
            </div>
            <!--
            <div class="h-36 w-1/6 service-logo pl-2 mx-auto float-left hidden sm:hidden lg:block md:block">
              <img class="h-20 w-20 mt-4 my-3 rounded-full"
                   :alt="service.title"
                   :src="'/storage/'+service.logo">
            </div>
            -->
            <div class="float-left service-content text-left w-full lg:w-full md:w-full sm:w-full">
              <h2 class="text-theme-color text-left ml-3 my-2 text-md title font-weight-bold">
                {{ service.title }}</h2>

              <!--                        <h3 class="text-2xl mx-auto text-center"><span class="font-weight-bold">Rating:</span> <span  :class="[(service.rating === 'not_rated' ? 'text-gray-500' : 'text-yellow-500'), (service.rating === 'promising' ? 'text-yellow-500' : ''), (service.rating === 'high' ? 'text-green-500' : '')] ">{{service.ratingTranslated}}</span></h3>-->
              <div class="text-left w-full text-xl font-weight-bolder flex ml-3 pb-3" v-if="true">
                <div class="w-1/2 text-sm  text-left">
                  <p class="text-left"><i class="fas fa-city"></i>
                    {{ service.city.name }}</p>
                  <p class="text-left mt-1"><i class="fas fa-bookmark"></i>
                    {{ service.category.name }}
                  </p>
                </div>
                <div class="w-1/2 text-sm text-left">
                  <p class="text-left"><i class="fas fa-calendar-alt"></i>
                    {{ service.date_from }}</p>
                  <p class="text-left mt-1"><i class="fas fa-clock"></i>
                    {{ service.start_time }}</p>
                </div>
              </div>

              <div class="ml-3" v-else>Bilgi Yok</div>

              <div class="w-full p-2 text-center mb-2">
                <a :href="service.type.slug + '/' + service.slug" class="w-full bg-theme-color text-white px-3 py-2 text-lg"><i class="fas fa-search"></i> Detay Görüntüle</a>
              </div>
              <div
                  class="grid lg:grid-cols-1 p-1 text-2xl absolute bottom-0 text-center -left-96 text-white bg-danger w-1/2 service-box-left-belt">
                <div class="inline-block mr-2">
                  <!--<i class="fas fa-wrench inline-block" v-for="(n, i) in parseInt(service.complexity)"></i>-->
                  <a :href="service.guide.twitter" target="_blank"
                     v-if="service.guide && service.guide.twitter !== null"><i
                      class="fab fa-twitter inline-block transition duration-300 hover:text-theme-color"></i></a>
                  <a :href="service.guide.telegram" target="_blank"
                     v-if="service.guide && service.guide.telegram !== null"><i
                      class="fab fa-telegram-plane inline-block transition duration-300 hover:text-theme-color"></i></a>
                  <a :href="service.guide.website" target="_blank"
                     v-if="service.guide && service.guide.website !== null"><i
                      class="fas fa-globe inline-block transition duration-300 hover:text-theme-color"></i></a>
                  <a :href="service.guide.facebook" target="_blank"
                     v-if="service.guide && service.guide.facebook !== null"><i
                      class="fab fa-facebook inline-block transition duration-300 hover:text-theme-color"></i></a>

                </div>
              </div>

              <div
                  class="grid lg:grid-cols-1 p-1 text-2xl absolute bottom-0 text-center -right-96 bg-theme-color text-white w-1/2 service-box-right-belt">
                <div class="inline"><p class="inline w-auto px-1 text-lg"
                                       v-for="type in service.types">
                  {{ type.title }} </p></div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: {services: Array},
  data() {
    return {
      categories: null,
      cities: null,
      services: [],
      lastAdded: [],
      links: '',
      loadMore: true,
      test: [],
      goBack: false,
      active: true,
      all: true,
      priced: false,
      free: false
    }
  },

  mounted() {

  },

  methods: {
    getServices() {
      this.free = false;
      this.priced = false;
      this.all = true;

      var url = '/etkinlikler';

      if (this.free === true) {
        url = url + '?status=free'
      }

      if (this.priced === true) {
        url = url + '?status=priced'
      }

      if (this.all === true) {
        url = url + '?status=all'
      }

      axios.get(url).then(response => {
        this.services = response.data.data;
        this.links = response.data.links;
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

      var url = '/etkinlikler?status=' + status;

      if (status === null) {
        url = '/services';
        this.goBack = false;
      }
      // if (status !== null && status === 'Ended') {
      //     this.goBack = true;
      // }
      axios.get(url).then(response => {
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

      console.log(nextUrl);
      axios.get(nextUrl).then(response => {
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
    },

    getCities() {
      axios.get('/cities').then(response => {
        this.cities = response.data.data;
      })
    },

    getCategories() {
      axios.get('/categories').then(response => {
        this.categories = response.data.data;
      })
    },

  }
}
</script>
