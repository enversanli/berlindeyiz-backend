<template>
    <div>
        <div class="lg:flex md:w-full">
        <div
            class="2xl:service-detail-menu lg:service-detail-menu w-full 2xl:w-1/2 lg:w-1/2 2xl:w-1/2 md:w-full sm:w-full float-left 2xl:m-3 lg:m-3 md:m-3 sm:m-0 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl p-3 md:mx-auto">
            <ul class="p-4 text-2xl uppercase">
                <li class="my-3 cursor-pointer transition duration-300 hover:pl-2" @click="setBlock('service')"><i class="fas fa-flag mr-2"></i> Service
                </li>
                <li class="my-3 cursor-pointer" @click="setBlock('guide')"><i class="fas fa-book-open mr-2"></i> Rehber
                </li>
                <li class="my-3 cursor-pointer" @click="setBlock('hardware')"><i class="fas fa-server"></i> Donanım
                </li>
                <li class="my-3 cursor-pointer" @click="setBlock('faq')"><i class="fas fa-question mr-2"></i> Sıkça Sorulan Sorular</li>
                <li class="my-3 cursor-pointer" @click="setBlock('faq')" v-if="service.guide && service.guide.get_in_url"><a :href="service.guide.get_in_url" target="_blank"><i class="fas fa-external-link-alt"></i> Bağlantı</a></li>
            </ul>
        </div>
        <div class="2xl:service-detail-content lg:service-detail-content md:w-full sm:w-full w-full float-left">
            <div class="h-auto m-3 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl p-3 ">
                <div class="flex">
                    <div class="flex-grow lg:text-left md:text-left text-2xl"><b>Durum:</b>
                      <span
                        :class="statusColor" class="font-weight-bold text-red-600 rounded-full h-7 w-7 inline-block -mb-1.5"></span></div>
<!--                    <div class="flex-grow text-right md:text-right text-2xl">-->
<!--                        <a :href="service.guide.twitter" target="_blank" v-if="service.guide && service.guide.twitter !== null"><i class="fab fa-twitter inline-block transition duration-300 hover:text-theme-color"></i></a>-->
<!--                        <a :href="service.guide.telegram" target="_blank" v-if="service.guide && service.guide.telegram !== null"><i class="fab fa-telegram-plane inline-block transition duration-300 hover:text-theme-color"></i></a>-->
<!--                        <a :href="service.guide.website" target="_blank" v-if="service.guide && service.guide.website !== null"><i class="fas fa-globe inline-block transition duration-300 hover:text-theme-color" ></i></a>-->
<!--                        <a :href="service.guide.facebook" target="_blank" v-if="service.guide && service.guide.facebook !== null"><i class="fab fa-facebook inline-block transition duration-300 hover:text-theme-color"></i></a>-->
<!--                    </div>-->
                </div>

                <div class="" v-if="serviceBlock">
                    <div class="h-28 w-28 mx-auto" v-if="service.logo">
                        <img class="h-full w-full my-3 rounded-full"
                             :src="'/storage/'+service.logo">
                    </div>
                    <h2 class="text-black text-center my-3 text-4xl animate__animated animate__fadeIn">
                        {{ service.title }}</h2>
                    <div class="w-full text-justify text-xl p-3 animate__animated animate__backInRight" v-html="service.text">

                    </div>

                    <hr>

                </div>

                <div class="" v-else-if="guideBlock && service.guide">
                    <h2 class="text-black text-center my-3 text-4xl animate__animated animate__backInLeft">
                        {{ service.title }}</h2>
                    <div v-html="service.guide.text"
                         class="w-full text-left text-xl p-3 animate__animated animate__backInRight guide-content">

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

                <div class="animate__animated animate__fadeIn" v-else-if="faqBlock && service.questions.length > 0">
                    <div class="w-full md:w-7/12 lg:w-full mx-auto relative p-20">
                        <h1 class="text-3xl text-center font-bold text-black">Faq</h1>
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
                <div class="animate__animated animate__fadeIn" v-else-if="hardwareBlock && service.system_requirement">
                    <div class="w-full lg:w-full mx-auto relative 2xl:p-20 lg:p-20 md:p-20 sm:p-10">
                        <h1 class="text-3xl text-center font-bold text-black">System Requirement</h1>
                        <div class="border-l-2 mt-10 animate__animated animate__fadeIn">
                            <div
                                class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-4 bg-theme-color text-white rounded mb-10 flex-col md:flex-row space-y-4 md:space-y-0"

                            >
                                <div
                                    class="w-5 h-5 bg-theme-color absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>

                                <div class="w-10 h-1 bg-blue-300 absolute -left-10 z-0 mt-2"></div>

                                <div class="lg:flex w-full p-3 text-3xl border border-black">
                                    <div class="w-full">
                                        <p class="my-3"><b>Ram:</b> {{ service.system_requirement.ram }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-l-2 mt-10 animate__animated animate__fadeIn">
                            <div
                                class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-4 bg-theme-color text-white rounded mb-10 flex-col md:flex-row space-y-4 md:space-y-0"

                            >
                                <div
                                    class="w-5 h-5 bg-theme-color absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>

                                <div class="w-10 h-1 bg-blue-300 absolute -left-10 z-0 mt-2"></div>

                                <div class="lg:flex w-full p-3 text-3xl border border-black">
                                    <div class="w-full">
                                        <p class="my-3"><b>İşlemci:</b> {{ service.system_requirement.cpu }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-l-2 mt-10 animate__animated animate__fadeIn">
                            <div
                                class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-4 bg-theme-color text-white rounded mb-10 flex-col md:flex-row space-y-4 md:space-y-0"

                            >
                                <div
                                    class="w-5 h-5 bg-theme-color absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>

                                <div class="w-10 h-1 bg-blue-300 absolute -left-10 z-0 mt-2"></div>

                                <div class="lg:flex w-full p-3 text-3xl border border-black">
                                    <div class="w-full">
                                        <p class="my-3"><b>Depolama:</b> {{ service.system_requirement.storage }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-l-2 mt-10 animate__animated animate__fadeIn">
                            <div
                                class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-4 bg-theme-color text-white rounded mb-10 flex-col md:flex-row space-y-4 md:space-y-0"

                            >
                                <div
                                    class="w-5 h-5 bg-theme-color absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>

                                <div class="w-10 h-1 bg-blue-300 absolute -left-10 z-0 mt-2"></div>

                                <div class="lg:flex w-full p-3 text-3xl border border-black">
                                    <div class="w-full">
                                        <p class="my-3"><b>Ağ:</b> {{ service.system_requirement.network }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="animate__animated animate__fadeIn" v-else>
                    <p class="w-full text-2xl text-center my-10">Not found for this service.</p>
                </div>
            </div>
        </div>
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
        }
    },

    mounted() {
        if (this.service.rating === 'not_rated') {
            this.service.rating = 'Puanlanmadı';
        }

        if (this.service.rating === 'promising') {
            this.service.rating = 'Umut Verici';
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
        if (this.service.status === 'Ended') {
            this.statusColor = 'bg-red-600';
        }
    },

    methods: {
        setBlock(block) {

            if (block === 'service') {
                this.serviceBlock = true;
                this.faqBlock = false;
                this.guideBlock = false;
                this.hardwareBlock= false;
            }
            if (block === 'guide') {
                this.serviceBlock = false;
                this.faqBlock = false;
                this.guideBlock = true;
                this.hardwareBlock= false;
            }
            if (block === 'faq') {
                this.serviceBlock = false;
                this.faqBlock = true;
                this.guideBlock = false;
                this.hardwareBlock= false;
            }
            if (block === 'hardware') {
                this.serviceBlock = false;
                this.faqBlock = false;
                this.guideBlock = false;
                this.hardwareBlock= true;
            }
        }

    }
}
</script>
