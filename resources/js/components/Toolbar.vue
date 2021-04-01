<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <b-navbar-brand :to="{ path: '/' }">Каталог товаров</b-navbar-brand>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <b-nav-item  :to="{ path: '/' }">Поиск</b-nav-item>
                <b-nav-item  :to="{ path: '/categories' }">Категории</b-nav-item>
                <b-nav-item  :to="{ path: '/products' }">Товары</b-nav-item>
            </div>
        </div>
    </nav>
</template>

<script>

export default {
    name: 'Toolbar'
}

</script>

<style>

</style>
