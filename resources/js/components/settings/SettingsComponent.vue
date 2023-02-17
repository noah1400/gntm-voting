<template>
    <div class="space-y-8 divide-y divide-gray-200 lg:mx-40 lg:px-15 md:mx-16 sm:mx-8 mx-4 mt-5">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5 flex-col flex md:grid md:grid-cols-2">
            <form enctype="multipart/form-data" ref="modelForm" id="modelForm">
                <div class="space-y-6 sm:space-y-5">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Neues Model</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Hier kannst du ein neues Model registrieren</p>
                    </div>

                    <div class="space-y-6 sm:space-y-5">
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Name</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <div class="flex max-w-lg rounded-md shadow-sm">
                                    <input type="text" name="name" id="name-model" autocomplete="name"
                                        class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:items-center sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex items-center">
                                <span class="h-12 w-12 overflow-hidden rounded-full bg-gray-100">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                                <button type="button" @click="openFileBrowser"
                                    class="ml-5 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Change</button>
                                <input @change="fileSelected" type="file" id="photo" name="photo" class="hidden" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-end">
                        <button v-on:click.prevent="addModel"
                            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Hinzufügen</button>
                    </div>
                    <span v-if="modelAdded" class="text-sm text-green-600">Model wurde erfolgreich hinzugefügt</span>
                </div>
            </form>
            <div>
                <div class="px-3 mt-4">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">Models</h1>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                Photo</th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Name
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-6 sm:pr-0">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr v-for="model in models" :key="model.id">
                                            <td
                                                class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100">
                                                    <img class="w-full h-full object-cover"
                                                        :src="'/storage/'+model.image" />
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{
                                                model.name
                                            }}</td>
                                            <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium sm:pr-0">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span
                                                        class="sr-only">, {{ model.name }}</span></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form ref="activityForm" id="activityForm">
                <div class="space-y-6 pt-8 sm:space-y-5 sm:pt-10">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Neue Aktivität</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Hier kannst du eine neue Aktivität registrieren
                        </p>
                    </div>
                    <div class="space-y-6 sm:space-y-5">
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Name</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <div class="flex max-w-lg rounded-md shadow-sm">
                                    <input type="text" name="name" id="name-activity" autocomplete="name"
                                        class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                            <label for="multiplier"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Multiplier</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <div class="flex max-w-lg rounded-md shadow-sm">
                                    <input type="text" name="multiplier" id="multiplier" value="1"
                                        class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-end">
                        <button v-on:click.prevent="addActivity"
                            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Hinzufügen</button>
                    </div>

                    <span v-if="activityAdded" class="text-sm text-green-600 ease-out">Aktivität wurde erfolgreich
                        hinzugefügt</span>
                </div>
            </form>
            <div>
                <div class="px-3 mt-4">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">Aktivitäten</h1>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                Name</th>
                                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                Gewichtung
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-6 sm:pr-0">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr v-for="activity in activities" :key="activity.id">
                                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{
                                                activity.name
                                            }}</td>
                                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{
                                                activity.multiplier
                                            }}</td>
                                            <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium sm:pr-0">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span
                                                        class="sr-only">, {{ activity.name }}</span></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form ref="episodeForm" id="episodeForm">
                <div class="space-y-6 pt-8 sm:space-y-5 sm:pt-10">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Neue Episode</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Hier kannst du eine neue Episode registrieren
                        </p>
                    </div>
                    <div class="space-y-6 sm:space-y-5">
                        <div
                            class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="number"
                                class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Number</label>
                            <div class="mt-1 sm:col-span-2 sm:mt-0">
                                <div class="flex max-w-lg rounded-md shadow-sm">
                                    <input type="text" name="number" id="number" autocomplete="number"
                                        class="block w-full min-w-0 flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-end">
                        <button v-on:click.prevent="addEpisode"
                            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Hinzufügen</button>
                    </div>

                    <span v-if="episodeAdded" class="text-sm text-green-600 ease-out">Episode wurde erfolgreich
                        hinzugefügt</span>
                </div>
            </form>
            <div>
                <div class="px-3 mt-4">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">Episodes</h1>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Name
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-6 sm:pr-0">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr v-for="episode in episodes" :key="episode.id">
                                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{
                                                episode.number
                                            }}</td>
                                            <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium sm:pr-0">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span
                                                        class="sr-only">, {{ episode.number }}</span></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

export default {
    name: "Settings",
    data() {
        return {
            activityAdded: false,
            modelAdded: false,
            episodeAdded: false,
            modelImage: null,

            models: [],
            activities: [],
            episodes: []
        }
    },
    created() {
        this.getModels();
        this.getActivities();
        this.getEpisodes();
    },
    methods: {
        addModel() {
            console.log('addModel');



            let formData = new FormData(document.getElementById('modelForm'));

            console.log(formData.get('name'));
            console.log(formData.get('photo'));

            axios.post('/api/models', formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    this.models.push(response.data);
                })
                .catch(error => {
                    console.log(error);
                });

            this.modelAdded = true;
            // Intervall für 3 Sekunden setzen
            setTimeout(() => {
                this.modelAdded = false;
            }, 3000);
        },
        getModels() {
            axios.get('/api/models')
                .then(response => {
                    this.models = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getActivities() {
            axios.get('/api/activities')
                .then(response => {
                    this.activities = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getEpisodes() {
            axios.get('/api/episodes')
                .then(response => {
                    this.episodes = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        addActivity() {

            let formData = new FormData(document.getElementById('activityForm'));

            axios.post('/api/activity', formData)
                .then(response => {
                    this.activities.push(response.data);
                })
                .catch(error => {
                    console.log(error);
                })

            this.activityAdded = true;
            // Intervall für 3 Sekunden setzen
            setTimeout(() => {
                this.activityAdded = false;
            }, 3000);
        },
        addEpisode() {

            let formData = new FormData(document.getElementById('episodeForm'));

            axios.post('/api/episode', formData)
                .then(response => {
                    this.episodes.push(response.data);
                })
                .catch(error => {
                    console.log(error);
                })

            this.episodeAdded = true;
            // Intervall für 3 Sekunden setzen
            setTimeout(() => {
                this.episodeAdded = false;
            }, 3000);
        },
        openFileBrowser() {
            document.getElementById('photo').click();
        },
        fileSelected() {
            this.modelImage = document.getElementById('photo').files[0];
            // check if file is an image
            if (this.modelImage.type.match('image.*')) {
                console.log('An image has been loaded');
            } else {
                console.log('The file is not an image');
                this.modelImage = null;
            }
        }
    }
}

</script>
