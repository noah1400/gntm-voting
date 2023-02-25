<template>
    <div class="mt-8 flow-root">
      <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th scope="col" class="py-3.5 pl-6 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Episode</th>
                <th v-for="a in activities" :key="a" scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">
                    {{ a }}
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="e in episodes" :key="e.episode" class="divide-x divide-gray-200">
                <td class="whitespace-nowrap py-4 pl-6 pr-4 text-sm font-semibold text-gray-900 sm:pl-0">{{ e.episode }}</td>
                <td v-for="a in e.activities" :key="a" class="whitespace-nowrap p-4 text-sm text-gray-500">
                    {{ a.count }}
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
    watch: {
        'stats': function (val, oldVal) {
            this.update()
        }
    },
    data() {
        return {
            model: '',
            episodes: {},
            activity: '',
            activities: [],
            count: 0,
            multiplier: 0
        }
    },
    methods: {
        update() {
            this.model = Object.keys(this.stats)[0];
            this.episodes = this.stats[this.model];
            // stats:
            // { "Heidi": { "1": { "Weint": { "count": 1, "multiplier": 1 }, "Geht": {...} }, "2": {...} }, "Lea": {...}, ... }
            // episodes:
            // [
            //    { "episode": 1
            //      "activities": {
            //          "Weint": { "count": 1, "multiplier": 1 },
            //          "Geht": { "count": 1, "multiplier": 1 },
            //          "Lacht": { "count": 1, "multiplier": 1 },
            //       }
            //    },
            //    { "episode": 2
            //      "activities": {
            //          "Weint": { "count": 1, "multiplier": 1 },
            //          "Geht": { "count": 1, "multiplier": 1 },
            //          "Lacht": { "count": 1, "multiplier": 1 },
            //       }
            //    },
            //    ...
            // ]
            let vm = this;

            this.episodes = Object.keys(this.episodes).map(episode => {
                let activities = this.episodes[episode];
                activities = Object.keys(activities).map(activity => {
                    let count = activities[activity].count;
                    let multiplier = activities[activity].multiplier;
                    if (vm.activities.indexOf(activity) === -1) {
                        vm.activities.push(activity);
                    }
                    return { activity, count, multiplier };
                });
                return { episode, activities };
            });

        }
    }

}
</script>
