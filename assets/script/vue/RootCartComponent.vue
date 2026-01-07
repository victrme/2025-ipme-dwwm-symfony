
<template>
    <div>

    </div>
</template>

<script lang="ts">

import {IGame} from "../interfaces/i-game";

export default {
    name: 'RootCartComponent',
    components: {},
    props: {
        propsGames: {
            type: Array<IGame>,
        },
    },
    data() {
        return {
            games: this.propsGames,
        }
    },
    mounted() {},
    computed: {},
    methods: {},
}

</script>
