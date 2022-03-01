<template>
    <div>
        <div class="w-full">
            <div class="h-auto m-3 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl p-3 ">
                <!--                    <div class="flex">-->
                <!--                        <div class="flex-grow text-left"><b>Status :</b>  <span>{{service.status}}</span></div>-->
                <!--                        <div class="flex-grow text-right"><b>Dates :</b> {{service.date_from}} - {{service.date_to}}</div>-->
                <!--                    </div>-->
                <h2 class="text-black text-center my-3 text-4xl animate__animated animate__backInLeft">
                    {{ service.title }}</h2>
                <div v-html="service.guide.text"
                     class="w-full text-justify text-xl p-3 animate__animated animate__backInRight">

                </div>
                <p class="text-center" v-for="type in service.types">{{ type.title }}</p>
                <div v-if="service.youtubevideoId !== null" class=" w-50 h-50 mx-auto ">

                        <p>You can watch video for this guide.</p>
                    <div class="youtube-video video-column w-full h-full">

                        <a :href="service.guide.youtube_url" data-fancybox="gallery">
                            <div class="overlay text-center text-white">
                                <i class="fas fa-play text-2xl play-icon"></i>
                            </div>
                            <img :src="'https://img.youtube.com/vi/' + service.youtubevideoId + '/sddefault.jpg'"
                                 class="w-full h-full">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['youtubeImgId', 'service'],
    data() {
        return {
            services: []
        }
    },

    mounted() {
        console.log(this.service);
    },

    methods: {}
}
</script>
