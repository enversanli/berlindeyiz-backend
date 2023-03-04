<template>
  <div>
    <header class="flex h-24 w-full px-3">
      <div class="flex-grow text-left h-24">
        <div class="flex">
          <div class="text-theme-color">
            <i class="fas fa-bars text-3xl mt-7 cursor-pointer " @click="toggleMenu()"></i></div>
          <div>
            <a href="/">
              <div class="mt-4 ml-2 text-lg">
                <img alt="Berlin Etkinlikleri" src="/images/berlindeyiz.png" class="h-8 inline-block float-left">
                <p class="pt-2 float-left">Berlin<b>DE</b>yiz</p>
              </div>
              <!--<img class="h-24" src="/images/logo.png">-->
            </a>
          </div>
        </div>
      </div>

      <!-- Search bar -->
      <div
          class="flex-grow text-center sm:hidden md:block lg:block hidden text-2xl lg:mr-10 sm:mr-1 theme-color relative"
          style="margin-top: 27px">
        <div class="w-full float-left">
        <input type="text" v-model="search_text" class="rounded-full border-gray-300 h-8" @keyup="search()"
               style="background-color: #f8fafc">
        <i class="fas fa-search align-middle cursor-pointer text-lg" @click="setModal"></i>
        <ul class="z-10 w-50 mx-auto bg-white p-1 flex-none absolute left-0 right-5 top-12 min-h-100 shadow"
            v-show="services">

          <li class="mx-1 my-1 p-1 w-full" v-for="service in services">
            <a :href="'/etkinlikler/' + service.slug">{{ service.title }}</a>
          </li>
        </ul>
        </div>
      </div>


      <!-- Social icons -->
      <div class="flex-grow lg:ml-10 sm:ml-1 text-2xl theme-color text-theme-color text-right"
           style="line-height: 96px">
        <a href="https://t.me/berlindeyiz" target="_blank"><i class="fab fa-telegram-plane mx-1"></i></a>
        <a href="https://www.instagram.com/berlindeyiz.de/?igshid=YmMyMTA2M2Y%3D" target="_blank"><i class="fab fa-instagram mx-1"></i></a>
        <a href="https://www.youtube.com/@berlindeyiz1961" target="_blank"><i class="fab fa-youtube mx-1"></i></a>
      </div>
    </header>
    <div class="position-fixed top-0 left-0 right-0 bottom-0 z-10 animate__animated d-none bg-gray-500 bg-opacity-50"
         :class="[(menu === true ? 'animate__fadeIn d-block' : 'animate__fadeOut')]">
      <div
          class="menu lg:w-1/4 md:w-1/3 sm:w-full w-full h-100 bg-white text-theme-color  absolute left-0 top-0 bottom-0 right-auto md:right-0 sm:right-0">
        <div class="absolute top-5 right-7">
          <i class="fas fa-times cursor-pointer text-2xl" @click="toggleMenu"></i>
        </div>
        <ul class="mt-20 text-3xl pl-5 font-weight-bold">
          <li class="my-4 ml-3"><a href="/"><i class="fas fa-home"></i> Anasayfa</a></li>
          <li class="my-4 ml-3"><a href="/duyurular"><i class="fas fa-bullhorn"></i> Duyurular</a></li>
          <!--<li class="my-4 ml-3"><a href="/validators"><i class="fas fa-ethernet"></i> Validatör</a></li>-->
          <li class="my-4 ml-3"><a href="/sikca-sorulan-sorular"><i class="far fa-question-circle"></i> S.S.S</a></li>
        </ul>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      services: '',
      search_text: '',
      modal: false,
      menu: false,
      categories: null,
    }
  },

  mounted() {
  },

  methods: {
    search() {
      this.services = null;
      if (this.search_text.length >= 3){
        axios.get('/search/' + this.search_text).then(response => {
          console.log(response.data);
          this.services = response.data.data;
        })
      }

    },

    setModal() {
      this.search_text = null;
      if (this.modal === false) {
        this.modal = true;
      } else {
        this.services = null;
        this.modal = false;
      }
    },

    toggleMenu() {
      if (this.menu === false) {
        this.menu = true;
      } else {
        this.menu = false;
      }
    }
  }
}
</script>
