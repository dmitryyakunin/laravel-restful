<template>
    <div>
        <toolbar/>
        <div class="container-fluid">
            <router-view/>
        </div>
    </div>
</template>

<script>
import Toolbar from './Toolbar.vue';

export default {
    name: "App",
    components: {
        Toolbar,
    },
}

</script>

<style scoped>

</style>
