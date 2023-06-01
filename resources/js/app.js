/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

var Lang = require('vuejs-localization');

//Notice that you need to specify the lang folder, in this case './lang'
Lang.requireAll(require.context('./lang', true, /\.js$/));

Vue.use(Lang);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('service-component', require('./components/service/ServiceComponent.vue').default);
Vue.component('service-box-component', require('./components/service/ServiceBoxComponent.vue').default);
Vue.component('searched-service-component', require('./components/service/SearchedServiceComponent.vue').default);
Vue.component('search-box-component', require('./components/SearchBoxComponent.vue').default);
Vue.component('service-detail-component', require('./components/service/ServiceDetailComponent.vue').default);
Vue.component('service-guide-component', require('./components/service/ServiceGuideComponent.vue').default);
Vue.component('service-ticket-create', require('./components/service/ticket/TicketCreateComponent.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('faq-component', require('./components/FaqComponent.vue').default);
Vue.component('announcement-component', require('./components/AnnouncementComponent.vue').default);
Vue.component('validator-component', require('./components/ValidatorComponent.vue').default);
Vue.component('slider-component', require('./components/SliderComponent.vue').default);
Vue.component('slider-box-component', require('./components/slider/SliderBoxComponent.vue').default);
Vue.component('service-options', require('./components/service/ServiceOptions.vue').default);
Vue.component('fw-adv', require('./components/other/FullWidthAdvComponent.vue').default);
Vue.component('articles', require('./components/article/ArticleListComponent').default);
Vue.component('article-detail', require('./components/article/ArticleDetailComponent').default);
Vue.component('draw', require('./components/other/DrawComponent').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
