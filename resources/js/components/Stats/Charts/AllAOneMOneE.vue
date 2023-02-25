<template>
<div>
<!-- <div id="chartDiv" style="width: 100%; height: 400px;"></div> -->
<div class="mt-8 flow-root">
      <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th scope="col" class="py-3.5 pl-6 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Aktivität</th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Anzahl</th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Multiplier</th>
                <th scope="col" class="py-3.5 pl-4 pr-6 text-left text-sm font-semibold text-gray-900 sm:pr-0">Punktzahl</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="m in points" :key="m.x" class="divide-x divide-gray-200">
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ m.x }}</td>
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ m.y }}</td>
                <td class="whitespace-nowrap p-4 text-sm text-gray-500">{{ m.z }}</td>
                <td class="whitespace-nowrap py-4 pl-4 pr-6 text-sm text-gray-500 sm:pr-0">{{ m.y*m.z }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>
</template>


<script>
import * as JSC from 'jscharting';

export default {
    props: {
        stats: {
            type: Object,
            required: true
        }
    },
    watch: {
        'stats': function () {
            this.update();
        }
    },
    data() {
        return {
            points: []
        }
    },
    methods: {
        update() {

            // create chart
            this.points = [];
            for (const [key, value] of Object.entries(this.stats)) {
                for (const [key2, value2] of Object.entries(value)) {
                    for (const [key3, value3] of Object.entries(value2)) {
                        this.points.push({
                            x: key3,
                            y: value3.count,
                            z: value3.multiplier
                        });
                    }
                }
            }

        }
    }
}
</script>
