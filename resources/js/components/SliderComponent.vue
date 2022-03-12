<template>
    <div>
        <carousel :autoplay="true" :loop="true" :items="1" :autoplaySpeed="1400" :dots="false" :nav="false" :margin="3" class="w-full h-2/3 animate__animated animate__fadeIn shadow shadow-sm mb-5" v-if="sliders.length > 0">
            <div class="w-full h-2/3 bg-danger overflow-hidden" v-for="slider in sliders">
                <img class="w-full"
                     style="height: 650px"
                     :src="slider.image">
            </div>
        </carousel>
    </div>
</template>

<script>
import carousel from 'vue-owl-carousel'

export default {
    components: {carousel},
    data() {
        return {
            sliders:[]
        }
    },

    mounted() {
        this.getSliders();
    },

    methods: {
        getSliders(){
            axios.get('/sliders').then(response => {
                this.sliders = response.data.data
            });
        }
    }
}
</script>
