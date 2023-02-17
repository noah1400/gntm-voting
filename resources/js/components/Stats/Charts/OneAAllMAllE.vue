<template>
    <div class="mt-8 flow-root">
      <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th scope="col" class="py-3.5 pl-6 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Episode</th>
                <th v-for="m in models" :key="m" scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">
                    {{ m }}
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="e in episodes" :key="e.episode" class="divide-x divide-gray-200">
                <td class="whitespace-nowrap py-4 pl-6 pr-4 text-sm font-semibold text-gray-900 sm:pl-0">{{ e.episode }}</td>
                <td v-for="m in e.models" :key="m" class="whitespace-nowrap p-4 text-sm text-gray-500">
                    {{ m.count }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    props: {
        stats: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            models: [],
            episodes: [],
        }
    },
    watch: {
        'stats': function (val, oldVal) {
            console.log('stats changed')
            this.update()
        }
    },
    methods: {
        update() {
            // stats:
            // { "Heidi": { "1": { "Weint": { "count": 1, "multiplier": 1 } }, "2": {...} }, "Lea": {...}, ... }
            // Only 1 Activity, multiple models and multiple episodes
            // this.models
            // ["Heidi", "Lea", ...]
            this.models = Object.keys(this.stats);
            // this.episodes
            //  [{ "episode": 1, "models": { "Heidi": { "activity": "Weint" ,"count": 1, "multiplier": 1 }, "Lea": {...}, ... } },...}]
            this.episodes = Object.keys(this.stats[this.models[0]]).map(episode => {
                let models = this.models.map(model => {
                    let activity = Object.keys(this.stats[model][episode])[0];
                    let count = this.stats[model][episode][activity].count;
                    let multiplier = this.stats[model][episode][activity].multiplier;
                    return {
                        model: model,
                        activity: activity,
                        count: count,
                        multiplier: multiplier
                    }
                });
                return {
                    episode: episode,
                    models: models
                }
            });
            console.log(this.episodes);
        }
    }
}
</script>
