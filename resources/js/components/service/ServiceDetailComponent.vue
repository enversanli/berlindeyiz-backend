<template>
  <div class="">
    <div class="container">
      <div class="lg:flex md:w-full">

        <div class="2xl:service-detail-content lg:service-detail-content md:w-full sm:w-full w-full float-left">
          <div class="h-auto m-3 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl p-3 ">
            <div class="flex">
              <div class="flex-grow lg:text-left md:text-left text-2xl"><b>Durum:</b>
                <span
                    :class="statusColor"
                    class="font-weight-bold text-red-600 rounded-full h-7 w-7 inline-block -mb-1.5"></span></div>
              <div>
                <span><i class="fas fa-eye"></i> {{ service.visit_count }}</span>
              </div>
              <!--                    <div class="flex-grow text-right md:text-right text-2xl">-->
              <!--                        <a :href="service.guide.twitter" target="_blank" v-if="service.guide && service.guide.twitter !== null"><i class="fab fa-twitter inline-block transition duration-300 hover:text-theme-color"></i></a>-->
              <!--                        <a :href="service.guide.telegram" target="_blank" v-if="service.guide && service.guide.telegram !== null"><i class="fab fa-telegram-plane inline-block transition duration-300 hover:text-theme-color"></i></a>-->
              <!--                        <a :href="service.guide.website" target="_blank" v-if="service.guide && service.guide.website !== null"><i class="fas fa-globe inline-block transition duration-300 hover:text-theme-color" ></i></a>-->
              <!--                        <a :href="service.guide.facebook" target="_blank" v-if="service.guide && service.guide.facebook !== null"><i class="fab fa-facebook inline-block transition duration-300 hover:text-theme-color"></i></a>-->
              <!--                    </div>-->
            </div>

            <div class="" v-if="serviceBlock">
              <div class="h-96 w-full mx-auto" v-if="service.logo">
                <div class="w-full z-10 p-2 bg-red-600 text-center text-white mt-3 mb-1 text-lg" v-show="service.status === 'OUT_OF_DATE'"><p>Etkinlik Sona Erdi<p></p></div>
                <img class="h-full w-full my-3 rounded-b-32"
                     :src="'/storage/'+service.logo">

              </div>
              <h2 class="text-black text-center my-3 text-4xl animate__animated animate__fadeIn">
                {{ service.title }}</h2>
              <div class="w-full text-justify text-xl p-3 animate__animated animate__backInRight service-detail"
                   v-html="service.text">

              </div>

              <hr>

            </div>

            <div class="animate__animated animate__fadeIn" v-else-if="faqBlock && service.questions.length > 0">
              <div class="w-full md:w-7/12 lg:w-full mx-auto relative p-2 mt-5">
                <h1 class="text-3xl text-center font-bold text-black">Sıkça Sorulan Sorular</h1>
                <div class="border-l-2 mt-10">
                  <!-- Card 1 -->
                  <div
                      class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-4 bg-theme-color text-white rounded mb-10 flex-col md:flex-row space-y-4 md:space-y-0"
                      v-for="question in service.questions"
                  >
                    <div
                        class="w-5 h-5 bg-theme-color absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>

                    <div class="w-10 h-1 bg-blue-300 absolute -left-10 z-0 mt-2"></div>

                    <div class="flex-auto">
                      <h1 class="text-xl font-bold">{{ question.title }}</h1>
                      <h3>{{ question.text }}</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="animate__animated animate__fadeIn" v-else>
              <p class="w-full text-2xl text-center my-10">Bulunamadı.</p>
            </div>
          </div>
        </div>

        <div
            class="mb-5 h-96 2xl:service-detail-menu lg:service-detail-menu w-full 2xl:w-1/2 lg:w-1/2 2xl:w-1/2 md:w-full sm:w-full float-left 2xl:m-3 lg:m-3 md:m-3 sm:m-0 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl p-3 md:mx-auto">
          <ul class="p-4 text-xl uppercase">
            <li class="my-3 cursor-pointer transition duration-300 hover:pl-2" @click="setBlock('service')"><i
                class="fas fa-flag mr-2"></i> Etkinlik
            </li>
            <li class="my-3 cursor-pointer" @click="setBlock('faq')"><i class="fas fa-question mr-2"></i> Sıkça Sorulan
              Sorular
            </li>
            <li class="my-3 cursor-pointer" @click="setBlock('faq')" v-if="service.guide && service.guide.get_in_url"><a
                :href="service.guide.get_in_url" target="_blank"><i class="fas fa-external-link-alt"></i> Bağlantı</a>
            </li>
          </ul>

          <hr class="mb-4">

          <ul class="w-full px-4 text-xl">
            <li class="w-1/2 float-left inline-block my-2"><i class="fas fa-map-marker-alt"></i> {{ service.city.name }}
            </li>
            <li class="w-1/2 float-left inline-block my-2"><i class="fas fa-bookmark"></i> {{ service.category.name }}
            </li>
            <li class="w-1/2 float-left inline-block my-2"><i class="fas fa-calendar-alt"></i> {{ service.date_from }}
            </li>
            <li class="w-1/2 float-left inline-block my-2"><i class="fas fa-clock"
                                                              v-if="service.start_time !== null"></i>
              {{ service.start_time }}
            </li>
          </ul>

        </div>

      </div>
      <slider-box-component title="Aynı Şehirde Diğer Etkinlikler" :rows="this.similar"></slider-box-component>
    </div>
  </div>
</template>

<script>
export default {
  props: ['service', 'youtubeImgId'],
  data() {
    return {
      statusColor: '',
      serviceBlock: true,
      faqBlock: false,
      guideBlock: false,
      hardwareBlock: false,
      similar: []
    }
  },

  mounted() {
    this.getCityServices();

    if (this.service.is_priced === 1) {
      this.service.rating = 'Ücretli';
    }

    if (this.service.is_priced === 0) {
      this.service.rating = 'Ücretsiz';
    }

    if (this.service.rating === 'high') {
      this.service.rating = 'Yüksek';
    }

    if (this.service.status === 'ACTIVE') {
      this.statusColor = 'bg-green-600';
    }
    if (this.service.status === 'Upcoming') {
      this.statusColor = 'bg-yellow-600';
    }
    if (this.service.status === 'OUT_OF_DATE') {
      this.statusColor = 'bg-red-600';
    }
  },

  methods: {
    setBlock(block) {

      if (block === 'service') {
        this.serviceBlock = true;
        this.faqBlock = false;
        this.guideBlock = false;
        this.hardwareBlock = false;
      }
      if (block === 'guide') {
        this.serviceBlock = false;
        this.faqBlock = false;
        this.guideBlock = true;
        this.hardwareBlock = false;
      }
      if (block === 'faq') {
        this.serviceBlock = false;
        this.faqBlock = true;
        this.guideBlock = false;
        this.hardwareBlock = false;
      }
      if (block === 'hardware') {
        this.serviceBlock = false;
        this.faqBlock = false;
        this.guideBlock = false;
        this.hardwareBlock = true;
      }
    },
    getCityServices() {
      var url = '/sehir-etkinlikleri/' + this.service.city.slug;

      axios.get(url).then(response => {
        this.similar = response.data.data;
      })
    },

  }
}
</script>
