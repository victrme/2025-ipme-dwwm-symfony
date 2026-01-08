
<template>
    <div>

    </div>
</template>

<script lang="ts">

import {ICart} from "../interfaces/i-cart";
import {PropType} from "vue";

export default {
    name: 'RootCartComponent',
    components: {},
    props: {
        propsCart: {
            type: Object as PropType<ICart>,
        },
    },
    data() {
        return {
            cart: this.propsCart,
        }
    },
    mounted() {},
    computed: {},
    methods: {},
}

</script>
