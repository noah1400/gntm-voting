<template>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-12 px-6 text-center lg:px-8 lg:py-24">
            <div class="space-y-8 sm:space-y-12">
                <div class="space-y-5 sm:mx-auto sm:max-w-xl sm:space-y-4 lg:max-w-5xl">
                    <div class="flex w-100 flex-row justify-between">
                        <a href="/">
                            <button class="bg-gray-50 p-5 rounded hover:bg-gray-200">Zurück</button>
                        </a>
                        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl my-auto">Alle Models</h2>
                        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl my-auto">Aktivität: {{ activity.name }}
                            in {{ this.$parent.selected_episode.name }}
                        </h2>
                    </div>
                </div>
                <ul role="list"
                    class="mx-auto grid grid-cols-2 gap-x-3 gap-y-7 sm:grid-cols-3 md:gap-x-5 lg:max-w-5xl lg:gap-x-7 lg:gap-y-11 xl:grid-cols-5">
                    <li v-for="model in models" :key="model.name" @click="modelClicked(model.id)">
                        <div class="space-y-4">
                            <img class="mx-auto h-32 w-32 rounded-full lg:h-36 lg:w-36 transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300"
                                :src="'storage/' + model.image" alt="" />
                            <div class="space-y-2">
                                <div class="text-lg font-medium lg:text-xl">
                                    <h3>{{ model.name }}</h3>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created() {
        // get activity argument from url
        const urlParams = new URLSearchParams(window.location.search);
        const activity = urlParams.get('activity');
        // if activity argument is set and is a number, set activity_id
        if (activity && activity > 0) {
            this.activity_id = activity;
            this.getActivity();
        } else {
            // redirect to home page
            window.location.href = '/';
        }
        this.getModels();
    },
    data() {
        return {
            models: [],
            model: {
                id: '',
                name: '',
                description: '',
                image: '',
                created_at: '',
                updated_at: ''
            },
            activity: {
                id: '',
                name: '',
                description: '',
                created_at: '',
                updated_at: ''
            },
            errors: [],
            isEdit: false,
            activity_id: -1,
        }
    },
    methods: {
        getModels() {
            axios.get('/api/models')
                .then(response => {
                    this.models = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },
        modelClicked(id) {
            this.model = this.models.find(model => model.id === id);
            this.increaseActivity();
        },
        increaseActivity() {
            console.log('increase activity' + this.activity_id);
            axios.post('/api/models/' + this.model.id + '/incr/' + this.activity_id)
                .then(response => {
                    this.model = response.data
                    window.location.href = '/';
                })
                .catch(error => {
                    console.log(error)
                })

        },
        getActivity() {
            axios.get('/api/activity/' + this.activity_id)
                .then(response => {
                    this.activity = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },
    }
}
</script>
