
<template>
    <a  v-for="game in cart.gamesDTO"  class="text-decoration-none" :href="game.urlShow">
        <div class="d-flex">
            <div class="col-2">
                <img class="w-100" :src="game.thumbnailCover" :alt="'Couverture de ' + game.name">
            </div>
            <div class="col-10">
                <div class="ps-3">
                    <h2>{{ game.name }}</h2>
                    <p>{{ game.price }}€</p>
                </div>
            </div>
        </div>
    </a>
    <div class="mt-3">
        <h3>Total : {{ cart.totalPrice }}€</h3>
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
