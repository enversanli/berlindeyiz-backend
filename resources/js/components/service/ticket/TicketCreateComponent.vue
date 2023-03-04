<template>
  <div class="mb-10">
    <div class="flex justify-center min-h-screen">

      <div class="flex items-center w-full max-w-3xl p-8 mx-auto lg:px-12 lg:w-3/5">
        <div class="w-full">
          <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
            <i class="fas fa-ticket-alt"></i> Hemen Biletinizi Ayırt Edin
          </h1>

          <p class="mt-4 text-gray-500 dark:text-gray-400">
            <b><a :href="'/etkinlikler/' + service.slug">{{ service.title }}</a></b> için biletiniz, organizatör kişi/kuruluş aracılığı ile tarafınıza iletilecektir.
          </p>
          <p  class="mt-4 text-gray-500 dark:text-gray-400">
            <small>Bilet satış konusunda berlindeyiz.de, herhangi bir dijital ödeme alma imkanı sunmamaktadır ve oluşacak olan mali konulardan asla sorumlu değildir.</small>
          </p>

          <p  class="mt-1 text-gray-500 dark:text-gray-400">
            <small>Aşağıdaki formu doldurduğunuzda, kişisel verilerinizin sisteme kayıt edilmesi ve işlenmesi konusunda izin vermiş sayılırsınız.</small>
          </p>
          <!--
                    <div class="mt-6">
                      <div class="mt-3 md:flex md:items-center md:-mx-2">
                        <button
                            class="flex justify-center w-full px-6 py-3 text-white bg-blue-500 rounded-md md:w-auto md:mx-2 focus:outline-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                               stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                          </svg>

                          <span class="mx-2">
                                          client
                                      </span>
                        </button>

                        <button
                            class="flex justify-center w-full px-6 py-3 mt-4 text-blue-500 border border-blue-500 rounded-md md:mt-0 md:w-auto md:mx-2 dark:border-blue-400 dark:text-blue-400 focus:outline-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                               stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                          </svg>

                          <span class="mx-2">
                                          worker
                                      </span>
                        </button>
                      </div>
                    </div>
          -->
          <div class="mb-10 mt-5">
            <label class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Ad <span class="text-red-600">*</span></label>
            <input type="text" placeholder="Aslı"
                   v-model="firstName"
                   required
                   class="block w-full px-5 py-3 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40"/>
          </div>

          <div class="mb-10">
            <label class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Soyad <span class="text-red-600">*</span></label>
            <input type="text" placeholder="Gün"
                   v-model="lastName"
                   required
                   class="block w-full px-5 py-3 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40"/>
          </div>

          <div class="mb-10">
            <label class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Telefon Numarası <span class="text-red-600">*</span></label>
            <input type="text" placeholder="XXX-XX-XXXX-XXX"
                   v-model="phone"
                   required
                   class="block w-full px-5 py-3 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40"/>
          </div>

          <div class="mb-10">
            <label class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Email <span class="text-red-600">*</span></label>
            <small>Gerçek bir mail adresi girmelisiniz. Örn : birisi@mail.com</small>
            <input type="email" placeholder="birisi@mail.com"
                   v-model="email"
                   required
                   class="block w-full px-5 py-3 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40"/>
          </div>

          <div class="mb-5">
            <p class="text-red-600">{{errorMessage}}</p>
          </div>

          <button
              @click="store"
              class="flex items-center justify-between w-full px-6 py-3 text-lg tracking-wide text-white capitalize transition-colors duration-300 transform bg-theme-color rounded-md hover:bg-theme-color-100 focus:outline-none focus:ring focus:bg-theme-color-300 focus:ring-opacity-50">
            <span><i class="fas fa-ticket-alt"></i> Hemen Rezerve Et </span>

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:-scale-x-100" viewBox="0 0 20 20"
                 fill="currentColor">
              <path fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"/>
            </svg>
          </button>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TicketCreateComponent",
  props: ['service'],

  data() {
    return {
      firstName: '',
      lastName: '',
      phone: '',
      email: '',
      birthDate: '',
      errorMessage: '',
    }
  },

  mounted() {

  },

  methods: {
    store() {
      const data = {
        'service_id': this.service.id,
        'first_name': this.firstName,
        'last_name': this.lastName,
        'phone': this.phone,
        'email': this.email,
      };


      axios.post('/etkinlikler/' + this.service.slug + '/ticket', data).then(response => {
        alert(response.data.message);

        this.firstName = '';
        this.lastName = '';
        this.phone = '';
        this.email = '';

      }).catch(e =>{
          if (e.response.status === 422){
            this.errorMessage = 'Lütfen zorunlu alanları doldurunuz.'
          }
      });
    }
  }
}
</script>

<style scoped>

</style>