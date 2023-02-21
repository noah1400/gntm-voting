<template>
    <nav class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
            <div class="flex h-20 justify-between">
                <div class="flex px-2 lg:px-0">

                    <div class="flex flex-shrink-0 items-center">
                        <a href="/">
                            <img class="block h-8 w-auto lg:hidden"
                                src="storage/imp/gntm.png"
                                alt="Your Company">
                            <img class="hidden h-8 w-auto lg:block"
                                src="storage/imp/gntm.png"
                                alt="Your Company">
                        </a>
                        <div class="m-5">
                            <label for="episode" class="block text-sm font-medium text-gray-700">Episode</label>
                            <select id="episode" name="episode" v-model="selected_episode"
                                class="mt-1 block w-52 lg:w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                @change="selectEpisode">
                                <option disabled value="">Bitte wähle eine Episode aus: </option>
                                <option v-for="episode in episodes" :key="episode.number" :value="episode.number">
                                    {{ episode.number }}
                                </option>
                            </select>
                        </div>
                        <a href="/stats">
                            <button type="button"
                                class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Stats</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>

                            </button>
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="relative ml-4 flex-shrink-0">
                        <div>
                            <a href="/settings">
                                <button type="button"
                                    class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Settings</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <component :is="component" v-if="selected_episode || component.name == 'Settings'
    || component.name == 'Stats'"></component>
    <div v-if="!selected_episode && component.name != 'Settings'">
        <div class="flex items-center justify-center h-screen">
            Bitte wähle eine Episode aus oder erstelle eine neue.
        </div>
    </div>
</template>

<script>
import { shallowRef } from '@vue/reactivity';
import ActivityComponent from '../Activities/ActivityComponent.vue';
import SettingsComponent from '../settings/SettingsComponent.vue';

import ModelComponent from '../TopModels/ModelComponent.vue';
import StatsComponent from '../Stats/StatsComponent.vue';
export default {
    created() {
        this.open = false
        this.routes = [
            {
                path: '/',
                component: ActivityComponent,
            },
            {
                path: '/settings',
                component: SettingsComponent,
            },
            {
                path: '/models',
                component: ModelComponent,
            },
            {
                path: '/stats',
                component: StatsComponent,
            }

        ]
        // get route from url starts with
        const route = this.routes.find(route => route.path === window.location.pathname)

        if (route === undefined) {
            window.location.href = '/'
        }
        // set component
        this.component = route.component

        this.getValues = route.query;
        this.getEpisodes();
    },
    data() {
        return {
            routes: [],
            component: shallowRef(null),
            open: false,
            getValues: {},
            selected_episode: null,
            episodes: [],
        }
    },
    methods: {
        getEpisodes() {
            axios.get('/api/episodes').then(response => {
                this.episodes = response.data
            }).catch(error => {
                console.log(error)
            }).finally(() => {
                this.getSelectedEpisode();
            })
        },
        getSelectedEpisode() {
            axios.get('/api/episode/selected').then(response => {
                var e = this.episodes.find(episode => episode.id == response.data.id)
                this.selected_episode = e ? e.number : this.episodes[0].number;
                if (this.selected_episode) {
                    this.selectEpisode();
                }
            }).catch(error => {
                console.log(error)
            })
        },
        selectEpisode() {
            let i = this.episodes.find(episode => episode.number == this.selected_episode).id
            let vm = this;
            axios.post('/api/episode/select/' + i)
                .then(response => {
                    if (response.data) {
                        this.selected_episode = this.episodes.find(episode => episode.id == response.data).number;
                    }
                }).catch(error => {
                    console.log(error)
                })
        },
    }
}


</script>
