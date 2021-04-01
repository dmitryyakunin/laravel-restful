<template>
    <div>
        <toolbar/>
        <div class="container-fluid main-position">
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

<style>

.main-position {
    padding: 20px;
}

.position {
    margin-top: 10px;
    margin-bottom: 5px;
}

</style>
