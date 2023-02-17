<template>
    <component :is="comp" :stats="stats"></component>
</template>

<script>
import { shallowRef } from '@vue/reactivity';
import OneAAllMOneE from './Charts/OneAAllMOneE.vue';
import OneAOneMOneE from './Charts/OneAOneMOneE.vue';
import AllAOneMOneE from './Charts/AllAOneMOneE.vue';
import AllAAllMOneE from './Charts/AllAAllMOneE.vue';
import OneAOneMAllE from './Charts/OneAOneMAllE.vue';
import AllAOneMAllE from './Charts/AllAOneMAllE.vue';
import OneAAllMAllE from './Charts/OneAAllMAllE.vue';
import AllAAllMAllE from './Charts/AllAAllMAllE.vue';

export default {
    data() {
        return {
            comp: shallowRef(null)
        }
    },
    props: {
        stats: {
            type: Object,
            required: true
        },
        sA: {
            type: Number,
            required: false
        },
        sM: {
            type: Number,
            required: false
        },
        sE: {
            type: Number,
            required: false
        }
    },
    watch: {
        'sA': function (val, oldVal) {
            console.log('sA changed')
            this.update()
        },
        'sM': function (val, oldVal) {
            console.log('sM changed')
            this.update()
        },
        'sE': function (val, oldVal) {
            console.log('sE changed')
            this.update();
        }
    },
    methods: {
        update() {

            if (this.sA != -1 && this.sM == -1 && this.sE != -1) {
                this.comp = OneAAllMOneE;
            } else if (this.sA != -1 && this.sM != -1 && this.sE != -1) {
                this.comp = OneAOneMOneE;
            } else if (this.sA == -1 && this.sM != -1 && this.sE != -1){
                this.comp = AllAOneMOneE;
            } else if (this.sA == -1 && this.sM == -1 && this.sE != -1){
                this.comp = AllAAllMOneE;
            } else if (this.sA != -1 && this.sM != -1 && this.sE == -1){
                this.comp = OneAOneMAllE;
            } else if (this.sA == -1 && this.sM != -1 && this.sE == -1){
                this.comp = AllAOneMAllE;
            } else if (this.sA != -1 && this.sM == -1 && this.sE == -1){
                this.comp = OneAAllMAllE;
            } else if (this.sA == -1 && this.sM == -1 && this.sE == -1){
                this.comp = AllAAllMAllE;
            }
            else{
                this.comp = null;
            }
        }
    }
}
</script>
