<template>
  <div class="container">
    <div class="container">
      <div class="lg:flex md:w-full">

        <div class="2xl:service-detail-content lg:service-detail-content md:w-full sm:w-full w-full float-left">
          <div class="h-auto m-3 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl p-3 ">
            <div class="flex">
              <div>
                <span><i class="fas fa-eye"></i> {{ article.read_count }}</span>
              </div>
            </div>

              <div class="h-auto w-full mx-auto" v-if="article.logo">
                <img class="min-hei-64 max-h-96 w-full my-3 rounded-b-32 rounded-md"
                     :src="'/storage/'+article.logo" :alt="article.title">

              </div>
              <h1 class="text-black text-center my-3 font-weight-bold text-2xl animate__animated animate__fadeIn">
                {{ article.translations[0].title }}
              </h1>
              <div class="w-full text-xl p-3 animate__animated animate__backInRight service-detail"
                   v-html="article.translations[0].content">
              </div>
          </div>
        </div>

      </div>
      <br>
      <slider-box-component title="Benzer Hizmetler" :rows="this.similar"></slider-box-component>

    </div>
  </div>
</template>

<script>

export default {
  name: "ArticleDetailComponent",
  props: ['slug'],
  data() {
    return {
      article: []
    }
  },

  mounted() {
    this.getArticle();
  },

  methods: {
    getArticle() {
        axios.get('/api/articles/' + this.slug).then(response =>{
          this.article = response.data.data;
        });
    }
  }
}
</script>

<style scoped>

</style>