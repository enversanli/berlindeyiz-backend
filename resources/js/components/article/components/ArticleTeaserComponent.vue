<template>
  <div>
      <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 mb-28">
        <a :href="article.link"
           class="animate__animated animate__fadeIn p-2"
           v-for="article in articles">
          <div
              class="h-94 m-3 p-1 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl relative overflow-hidden service-box pt-3">

            <div class="h-auto">
              <div class="w-full">
                <img class="h-64 xl:80 lg:h-72 md:h-64 sm:h-64 w-full px-3"
                     :alt="article.title"
                     :src="'https://berlindeyiz.de/storage/services/yLK3Xn4a8TzxUUcFUpmT8YTzZngKwXzHg9qXJ9Az.webp'">

              </div>

              <div class="float-left service-content text-left w-full lg:w-full md:w-full sm:w-full">
                <h2 class="text-theme-color text-center ml-3 my-4 text-md title font-weight-bold">
                  {{ article.translations[0].title }}</h2>

                <div class="w-full p-2 text-center mb-2">
                  <a :href="article.link" class="w-full bg-theme-color text-white px-3 py-2 text-lg"><i class="fas fa-search"></i> Tamamını Oku</a>
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
  name: "ArticleTeaserComponent",

  props: ['articles'],

  data(){
    return{
      translation : []
    }
  },


}
</script>