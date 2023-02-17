<template>
<div class="mt-8 flow-root">
      <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th scope="col" class="py-3.5 pl-6 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Episode</th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Anzahl</th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Multiplier</th>
                <th scope="col" class="py-3.5 pl-4 pr-6 text-left text-sm font-semibold text-gray-900 sm:pr-0">Punktzahl</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="e in episodes" :key="e.episode" class="divide-x divide-gray-200">
                <td class="whitespace-nowrap py-4 pl-6 pr-4 text-sm font-semibold text-gray-900 sm:pl-0">{{ e.episode }}</td>
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ e.count }}</td>
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ e.multiplier }}</td>
                <td class="whitespace-nowrap py-4 pl-4 pr-6 text-sm text-gray-500 sm:pr-0">{{ e.count*e.multiplier }}</td>
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
    watch: {
        'stats': function (val, oldVal) {
            console.log('stats changed')
            this.update()
        }
    },
    data() {
        return {
            model: '',
            episodes: {},
            activity: '',
            count: 0,
            multiplier: 0
        }
    },
    methods: {
        update() {
            this.model = Object.keys(this.stats)[0];
            this.episodes = this.stats[this.model];
            // new array
            // [
            //     {
            //         "episode": 1,
            //         "activity": "Geht",
            //         "count": 2,
            //         "multiplier": 1
            //     },
            //     {
            //         "episode": 2,
            //         "activity": "Geht",
            //         "count": 0,
            //         "multiplier": 1
            //     }
            // ]
            this.episodes = Object.keys(this.episodes).map((key) => {
                return {
                    episode: key,
                    activity: Object.keys(this.episodes[key])[0],
                    count: this.episodes[key][Object.keys(this.episodes[key])[0]].count,
                    multiplier: this.episodes[key][Object.keys(this.episodes[key])[0]].multiplier
                }
            });
        }
    }
}
</script>
