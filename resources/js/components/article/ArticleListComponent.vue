<template>
  <div class="container">
      <article-teaser-component :articles="articles"></article-teaser-component>
  </div>
</template>

<script>
import ArticleTeaserComponent from "./components/ArticleTeaserComponent";

export default {
  name: "ArticleListComponent",
  components: {ArticleTeaserComponent},
  data() {
    return {
      articles: []
    }
  },

  mounted() {
    this.getArticles();
  },

  methods: {
    getArticles() {
      axios.get('/api/articles').then(response => {
        this.articles = response.data.data;
      });
    }
  }
}
</script>

<style scoped>

</style>