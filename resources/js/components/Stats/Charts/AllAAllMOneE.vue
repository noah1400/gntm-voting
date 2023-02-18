<template>
    <div class="mt-8 flow-root">
      <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th scope="col" class="py-3.5 pl-6 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Model</th>
                <th v-for="m in act" :key="m" scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">
                    {{ m }}
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="m in dict" :key="m.id" class="divide-x divide-gray-200">
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ m.model }}</td>
                <td v-for="a in m.activities" :key="a.activity" class="whitespace-nowrap p-4 text-sm text-gray-500">
                    {{ a.count }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="mt-8 flow-root">
      <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th scope="col" class="py-3.5 pl-6 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Model</th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Punktzahl</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="(key, value) in points" :key="key" class="divide-x divide-gray-200">
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ value }}</td>
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ key }}</td>
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
            dict: [],
            act: [],
            points: {}
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
            
          console.log(this.stats)

            this.dict = [];
            this.act = [];
            var id_m = 0;
            for (const [key, value] of Object.entries(this.stats)) {
                let model = key;
                let stats = value;
                let activities = [];
                for (const [key, value] of Object.entries(stats)) {
                    let episode = value;
                    var id_a = 0;
                    for (const [name, activity] of Object.entries(episode)) {
                        if (!this.act.includes(name)) {
                            this.act.push(name);
                        }
                        let count = activity.count;
                        let mult = activity.multiplier;
                        activities.push({
                            id: id_a++,
                            activity: name,
                            count: count,
                            multiplier: mult
                        });
                    }
                }
                this.dict.push({
                    id: id_m++,
                    model: model,
                    activities: activities
                });
            }

            console.log(this.dict)

            // points means: sum of count * multiplier for each activity of each model
            this.points = {};
            for (const [key, value] of Object.entries(this.stats)) {
                let model = key;
                let stats = value;
                let points = 0;
                for (const [key, value] of Object.entries(stats)) {
                    let episode = value;
                    for (const [name, activity] of Object.entries(episode)) {
                        let count = activity.count;
                        let mult = activity.multiplier;
                        points += count * mult;
                    }
                }
                this.points[model] = points;
            }
            console.log(this.points);
        }
    }
}
</script>
