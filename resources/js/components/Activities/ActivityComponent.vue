<template>
    <div>
        <div class="mx-auto mt-40">
            <div v-if="lastcall" class="flex flex-row justify-center mb-5">
                <button type="button"
                    class="inline-flex items-centere rounded-md border border-transparent bg-red-100 px-6 py-3 text-base font-medium text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500  focus:ring-offset-2"
                    @click="revoke">Letzte Aktion rückgängig machen</button>
            </div>
            <div class="flex flex-row gap-4 justify-center flex-wrap">
                <div v-for="activity in activities" :key="activity.name">

                    <button type="button" @click="activityClicked(activity.id)"
                        class="inline-flex items-center rounded-md border border-transparent bg-indigo-100 px-6 py-3 text-2xl font-medium text-indigo-700 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">{{
    activity.name
                        }}</button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

export default {
    created() {
        this.getActivities();
        this.getLastCall();
    },
    data() {
        return {
            activities: [],
            lastcall: null
        }
    },
    methods: {
        getActivities() {
            axios.get('/api/activities')
                .then(response => {
                    this.activities = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        activityClicked(id) {
            window.location.href = "/models?activity=" + id;
        },
        getLastCall() {
            axios.get('/api/lastcall')
                .then(response => {
                    if (response.data.affected != undefined) {
                        this.lastcall = response.data;
                    }
                })
                .catch(error => {
                    console.log(error);
                })
        },
        revoke() {
            axios.post('/api/lastcall/revoke')
                .then(response => {
                    this.lastcall = null;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
}

</script>
