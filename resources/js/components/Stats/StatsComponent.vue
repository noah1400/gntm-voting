<template>
    <div class="lg:mx-40 lg:px-15 md:mx-16 sm:mx-8 mx-4 mt-5  space-y-8">
        <div class="flex flex-col md:grid-cols-2 md:grid">
            <div class="mx-3 mt-1">
                <label for="models" class="block text-sm font-medium text-gray-700">Models</label>
                <select id="models" name="models"
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    @change="modelChanged"
                    v-model="selectedModelId">
                    <option :value=-1>Alle</option>
                    <option v-for="model in models" :key="model.id" :value="model.id">{{ model.name }}</option>
                </select>
            </div>
            <div class="mx-3 mt-1">
                <label for="episodes" class="block text-sm font-medium text-gray-700">Episodes</label>
                <select id="episodes" name="episodes"
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    @change="episodeChanged"
                    v-model="selectedEpisodeId">
                    <option :value=-1>Alle</option>
                    <option v-for="episode in episodes" :key="episode.id" :value="episode.id">{{ episode.number }}</option>
                </select>
            </div>
            <div class="mx-3 mt-1">
                <label for="episodes" class="block text-sm font-medium text-gray-700">Aktivität</label>
                <select id="episodes" name="episodes"
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    @change="activityChanged"
                    v-model="selectedActivityId">
                    <option :value=-1>Alle</option>
                    <option v-for="activity in activities" :key="activity.id" :value="activity.id">{{ activity.name }}</option>
                </select>
            </div>
        </div>
    <div id="stats">
        <graph-component :stats="stats" :sA="selectedActivityId" :sM="selectedModelId" :sE="selectedEpisodeId"></graph-component>
    </div>
    </div>
</template>

<script>
import GraphComponent from './GraphComponent.vue';
export default {
    name : 'StatsComponent',
    components: {
        GraphComponent
    },
    data() {
        return {
            models: [],
            activities: [],
            episodes: [],
            selectedModel: null,
            selectedModelId: -1,
            selectedActivity: null,
            selectedActivityId: -1,
            selectedEpisode: null,
            selectedEpisodeId: -1,

            stats: {},
        }
    },
    created() {
        this.getModels();
        this.getActivities();
        this.getEpisodes();
    },
    methods: {
        getModels() {
            axios.get('/api/models')
                .then(response => {
                    this.models = response.data
                    this.selectedModel = this.models[0]
                    this.selectedModelId = this.selectedModel.id
                })
                .catch(error => {
                    console.log(error)
                })
        },
        modelChanged() {
            this.selectedModel = this.models.find(model => model.id == this.selectedModelId)
            this.getStats()
        },
        activityChanged() {
            this.selectedActivity = this.activities.find(activity => activity.id == this.selectedActivityId)
            this.getStats()
        },
        episodeChanged() {
            this.selectedEpisode = this.episodes.find(episode => episode.id == this.selectedEpisodeId)
            this.getStats()
        },
        getActivities() {
            axios.get('/api/activities')
                .then(response => {
                    this.activities = response.data
                    this.selectedActivity = this.activities[0]
                    this.selectedActivityId = this.selectedActivity.id
                })
                .catch(error => {
                    console.log(error)
                })
        },
        getEpisodes() {
            axios.get('/api/episodes')
                .then(response => {
                    this.episodes = response.data
                    this.selectedEpisode = this.episodes[0]
                    this.selectedEpisodeId = this.selectedEpisode.id
                })
                .catch(error => {
                    console.log(error)
                })
        },
        getStats() {

            let params = {};
            if (this.selectedModelId != -1) {
                params.model= this.selectedModelId
            }
            if (this.selectedActivityId != -1) {
                params.activity = this.selectedActivityId
            }
            if (this.selectedEpisodeId != -1) {
                params.episode = this.selectedEpisodeId
            }

            axios.get('/api/stats', {
                params: params
            })
                .then(response => {
                    this.stats = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }

}
</script>
