<template>
    <div class="mt-8 flow-root">
      <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Anzahl</th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Multiplier</th>
                <th scope="col" class="py-3.5 pl-4 pr-6 text-left text-sm font-semibold text-gray-900 sm:pr-0">Punktzahl</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr class="divide-x divide-gray-200">
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ count }}</td>
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ multiplier }}</td>
                <td class="whitespace-nowrap py-4 pl-4 pr-6 text-sm text-gray-500 sm:pr-0">{{ count*multiplier }}</td>
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
        }
    },
    data() {
        return {
            count: 0,
            model: "",
            episode: "",
            activity: "",
            multiplier: 0
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
            // { "Heidi": { "1": { "Weint": { "count": 1, "multiplier": 1 } } } }
            // this.count
            // 1
            // there is only one Model, one Episode and one Activity
            // so we can just get the count from the stats object
            this.count = this.stats[Object.keys(this.stats)[0]]
            [Object.keys(this.stats[Object.keys(this.stats)[0]])
            [0]][Object.keys(this.stats[Object.keys(this.stats)[0]]
            [Object.keys(this.stats[Object.keys(this.stats)[0]])[0]])[0]].count;

            // this.multiplier
            // 1
            // there is only one Model, one Episode and one Activity
            // so we can just get the multiplier from the stats object
            this.multiplier = this.stats[Object.keys(this.stats)[0]]
            [Object.keys(this.stats[Object.keys(this.stats)[0]])
            [0]][Object.keys(this.stats[Object.keys(this.stats)[0]]
            [Object.keys(this.stats[Object.keys(this.stats)[0]])[0]])[0]].multiplier;

            // this.model
            // "Heidi"
            this.model = Object.keys(this.stats)[0];

            // this.episode
            // "1"
            this.episode = Object.keys(this.stats[Object.keys(this.stats)[0]])[0];

            // this.activity
            // "Weint"
            // here Object.keys(this.stats["Heidi"]["1"])[0]

            this.activity = Object.keys(this.stats[Object.keys(this.stats)[0]]
            [Object.keys(this.stats[Object.keys(this.stats)[0]])[0]])[0];
        }
    }
}
</script>
