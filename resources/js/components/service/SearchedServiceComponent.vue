<template>
  <div>
    <!--    <slider-component></slider-component>-->
    <!--        <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 text-danger">-->
    <!--            <div-->
    <!--                class="h-7 w-1/2 mx-auto  m-3 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn"-->
    <!--                v-if="goBack === false"-->
    <!--                @click="filterServices('Ended')">-->
    <!--                <p class="text-center font-weight-bold"><i class="fas fa-history"></i> Ended</p>-->
    <!--            </div>-->
    <!--            <div-->
    <!--                class="h-7 w-1/2 mx-auto  m-3 p-1 bg-white shadow-md rounded-lg transition duration-700 hover:shadow-xl cursor-pointer animate__animated animate__fadeIn"-->
    <!--                v-if="goBack === true"-->
    <!--                @click="filterServices(null)">-->
    <!--                <p class="text-center font-weight-bold"><i class="fas fa-angle-double-left"></i> Go Back</p>-->
    <!--            </div>-->
    <!--        </div>-->
    <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 text-lg text-theme-color mt-28">
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
      <p class="w-full text-2xl text-center my-10">Not found services.</p>
    </div>
    <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1">
      <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 mb-28 h-96 pb-10">

        <a :href="'etkinlikler/' + service.slug" v-for="service in services"
           class="animate__animated animate__fadeIn">
          <div
              class="h-44 m-3 p-1 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl relative overflow-hidden service-box pt-3">
            <div class="h-8 w-40  transform -right-12 top-5 rotate-45 z-1 absolute"
                 :class="[(service.is_priced === 1 ? 'bg-red-500' : 'bg-green-500')] "
            >
              <p class="text-white  mt-2 text-center">{{ service.is_priced === 1 ? 'Ücretli' : 'Ücretsiz' }}</p>
            </div>

            <div class="">
              <div class="h-28 w-32 service-logo pl-2 mx-auto float-left">
                <img class="h-28 w-28 my-3 rounded-full"
                     :alt="service.title"
                     :src="'/storage/'+service.logo">
              </div>
              <div class="float-left service-content text-left">
                <h2 class="text-theme-color text-left ml-3 my-3 text-2xl title font-weight-bold">
                  {{ service.title }}</h2>

                <!--                        <h3 class="text-2xl mx-auto text-center"><span class="font-weight-bold">Rating:</span> <span  :class="[(service.rating === 'not_rated' ? 'text-gray-500' : 'text-yellow-500'), (service.rating === 'promising' ? 'text-yellow-500' : ''), (service.rating === 'high' ? 'text-green-500' : '')] ">{{service.ratingTranslated}}</span></h3>-->
                <div class="text-left w-full text-xl font-weight-bolder flex ml-3" v-if="true">
                  <div class="w-1/2 text-sm text-left">
                    <p class="text-left"><i class="fas fa-city mr-1"></i><small>Şehir:</small>
                      {{ service.city.name }}</p>
                    <p class="text-left mt-1"><i class="fas fa-network-wired mr-1"></i><small>Kategori:</small>
                      {{ service.category.name }}
                    </p>
                  </div>
                  <div class="w-1/2 text-sm text-left">
                    <p class="text-left"><i class="fa-solid fa-hourglass-start mr-1"></i><small>Tarih:</small>
                      {{ service.date_from }}</p>
                    <p class="text-left mt-1"><i class="fas fa-network-wired mr-1"></i><small>Saat:</small>
                      {{ service.start_time }}</p>
                  </div>
                </div>
                <div class="ml-3" v-else>Bilgi Yok</div>
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
        <div class="w-full">
          <button
              class="block mx-auto bpy-1 px-2 bg-theme-color text-white text-xl rounded shadow-sm transition duration-300 hover:bg-red-700"
              v-if="loadMore" @click="load"><i class="fas fa-arrow-down"></i> Daha Fazla
          </button>
        </div>
      </div>
      <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 p-3">
        <h1>Hello</h1>
      </div>
    </div>

    <slider-box-component title="Aynı Şehirde Diğer Etkinlikler" :rows="this.similar"></slider-box-component>

    <slider-box-component title="Son Eklenenler" :rows="this.lastAdded"></slider-box-component>
  </div>
</template>

<script>
export default {
  props: {
    city: String,
    category: String
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
    this.getCityServices();
  },

  methods: {
    searchService() {
      var url = '/etkinlik-ara?kategori=' + this.category + '&sehir=' + this.city;
      axios.post(url).then(response => {
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

      console.log(this.all);
      console.log(this.priced);
      console.log(this.free);

      var url = '/etkinlik-ara?kategori=' + this.category + '&sehir=' + this.city + '&status=' + status;

      if (status === null) {
        url = '/etkinlik-ara';
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

      axios.get(this.links.next).then(response => {
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

    getCityServices() {
      var url = '/sehir-etkinlikleri/' + this.city;
      axios.get(url).then(response => {
        this.similar = response.data.data;
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
