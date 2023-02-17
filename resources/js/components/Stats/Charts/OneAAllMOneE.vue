<template>
    <div>
    <div class="mt-8 flow-root">
      <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th scope="col" class="py-3.5 pl-6 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Model</th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Anzahl</th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Mutliplier</th>
                <th scope="col" class="py-3.5 pl-4 pr-6 text-left text-sm font-semibold text-gray-900 sm:pr-0">Punktzahl</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="m in series" :key="m.x" class="divide-x divide-gray-200">
                <td class="whitespace-nowrap py-4 pl-6 pr-4 text-sm font-medium text-gray-900 sm:pl-0">{{ m.x }}</td>
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ m.y }}</td>
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ multiplier }}</td>
                <td class="whitespace-nowrap py-4 pl-4 pr-6 text-sm text-gray-500 sm:pr-0">{{ m.y*multiplier }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>


    <!-- <div id="chartDiv" style="width: 100%; height: 400px;"></div> -->
</template>

<script>
import { shallowRef } from '@vue/reactivity';
export default {
    props: {
        stats: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            series: [],
            activity: '',
            multiplier: 1
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

            this.series = [];

            for (const [model, episodes] of Object.entries(this.stats)) {
                for (const [episode, activities] of Object.entries(episodes)) {
                    for (const [activity, activityStats] of Object.entries(activities)) {
                        this.series.push({ x: model, y: activityStats.count });
                    }
                }
            }

            //stats:
            // {
            //     "Hermine": {
            //         "1": {
            //         "Findet alles scheiße": {
            //             "count": 2,
            //             "multiplier": 1.5
            //         }
            //      }
            // }
            // activity = "Findet alles scheiße"
            // multiplier = 1.5

            var hermine = Object.keys(this.stats)[0];
            var episode = Object.keys(this.stats[hermine])[0];
            this.activity = Object.keys(this.stats[hermine][episode])[0];

            this.multiplier = this.stats[hermine][episode][this.activity].multiplier;

            // column chart with x-axis labels
            // title is activity name
            // const chart = new  JSC.Chart('chartDiv', {
            //     type: 'column',
            //     title: 'Activity',
            //     series: [
            //         {
            //             name: 'Models',
            //             points: this.series,
            //         }
            //     ]
            // }
            // )
        }
    }
}
</script>
