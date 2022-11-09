<template>
    <div>
        <div class="lg:flex md:w-full">
            <div class="float-left w-full">
                <div class="h-auto m-3 bg-white shadow-md rounded-lg transition duration-300 hover:shadow-xl p-3 ">

                    <div class="animate__animated animate__fadeIn" v-if="announcements.length > 0">
                        <div class="w-full  lg:w-full mx-auto relative 2xl:p-20 xl:p-20 lg:p-20 md:p-20 sm:p-10">
                            <h1 class="text-3xl text-center font-bold text-black">Duyurular</h1>
                            <div class="border-l-2 mt-10">
                                <div
                                    class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-4 bg-theme-color text-white rounded mb-10 flex-col md:flex-row space-y-4 md:space-y-0"
                                    v-for="announcement in announcements"
                                >
                                    <div
                                        class="w-5 h-5 bg-theme-color absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>

                                    <div class="w-10 h-1 bg-blue-300 absolute -left-10 z-0 mt-2"></div>

                                    <div class="flex-auto">
                                        <h1 class="text-xl font-bold">{{ announcement.title }}</h1>
                                        <h3>{{ announcement.text }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="animate__animated animate__fadeIn" v-else>
                        <p class="w-full text-2xl text-center my-10">Not found any announcement.</p>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['announcements'],
    data() {
        return {

        }
    },

    mounted() {
    },

    methods: {
    }
}
</script>
