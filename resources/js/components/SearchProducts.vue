<template>
    <div>
        <h4> Поиск товаров </h4>
        <div class="row">
            <div class="col-sm-6">
                <form>
                    <div class="form-group">
                        <!--                        <label for="searchString">Строка поиска</label>-->
                        <input type="text" class="form-control" id="searchString" placeholder="введите запрос"
                               v-model="searchString">
                    </div>
                    <div class="row">
                        <div class="form-group price-position" >
                            <input type="text" class="form-control" id="priceFrom" placeholder="цена от"
                                   v-model="priceFrom">
                        </div>
                        <div class="form-group price-position" >
                            <input type="text" class="form-control" id="priceTo" placeholder="цена до"
                                   v-model="priceTo">
                        </div>
                    </div>
                    <button class="btn btn-outline-primary buttonPosition" v-on:click="search()">
                        Найти
                    </button>
                </form>
            </div>
            <div class="col-sm-6">
                <div class="card" style="width: 30rem;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="searchType" id="radios0"
                                           value="option0" checked>
                                    <label class="form-check-label" for="radios0">
                                        все товары
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="searchType" id="radios1"
                                           value="option1" checked>
                                    <label class="form-check-label" for="radios1">
                                        имя товара
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="searchType" id="radios2"
                                           value="option2">
                                    <label class="form-check-label" for="radios2">
                                        id категории
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="searchType" id="radios3"
                                           value="option3">
                                    <label class="form-check-label" for="radios3">
                                        имя категории
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="searchType" id="radios4"
                                           value="option4" checked>
                                    <label class="form-check-label" for="radios4">
                                        цена от - до
                                    </label>
                                </div>                            </div>
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="searchType" id="radios5"
                                           value="option5">
                                    <label class="form-check-label" for="radios5">
                                        опубликованные
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="searchType" id="radios6"
                                           value="option6">
                                    <label class="form-check-label" for="radios6">
                                        неопубликованные
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="searchType" id="radios7"
                                           value="option7">
                                    <label class="form-check-label" for="radios7">
                                        неудаленные
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="searchType" id="radios8"
                                           value="option8">
                                    <label class="form-check-label" for="radios8">
                                        удаленные
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p></p>
        <table class="table table-bordered">
            <tr class="table-active">
                <th> ID</th>
                <th> Наименование</th>
                <th> Описание</th>
                <th> Цена</th>
            </tr>
            <tr v-for="item in products" :key="item.id">
                <td> {{ item.id }}</td>
                <td> {{ item.name }}</td>
                <td> {{ item.description }}</td>
                <td> {{ item.price }}</td>
            </tr>
        </table>
        <br/>

    </div>
</template>

<script>
import config from "../helpers/config";

export default {
    name: "Products",
    data: () => ({
        products: null,
        searchType: 'option0',
        searchString: null,
        priceFrom: null,
        priceTo: null,
    }),
    methods: {
        getProducts() {
            axios
                .get(config.endpoint + '/products/')
                .then(response => (this.products = response.data.data));
        },
        search() {
            if (this.searchType === 'option0') {    // все товары
                axios
                    .get(config.endpoint + '/products/')
                    .then(response => (this.products = response.data.data));
            }
            if (this.searchType === 'option1') {    // имя товара
                axios
                    .get(config.getSearchRoute('name', this.searchString,'null'))
                    .then(response => (this.products = response.data.data));
            }
            if (this.searchType === 'option2') {    // id категории
                axios
                    .get(config.getSearchRoute('category-id', this.searchString,'null'))
                    .then(response => (this.products = response.data.data));
            }
            if (this.searchType === 'option3') {    // Название категории
                axios
                    .get(config.getSearchRoute('category-name', this.searchString,'null'))
                    .then(response => (this.products = response.data.data));
            }
            if (this.searchType === 'option4') {    // цена от - до
                axios
                    .get(config.getSearchRoute('price', this.priceFrom, this.priceTo))
                    .then(response => (this.products = response.data.data));
            }
            if (this.searchType === 'option5') {    // опубликованные
                axios
                    .get(config.getSearchRoute('published', 1,'null'))
                    .then(response => (this.products = response.data.data));
            }
            if (this.searchType === 'option6') {    // неопубликованные
                axios
                    .get(config.getSearchRoute('published', 0,'null'))
                    .then(response => (this.products = response.data.data));
            }
            if (this.searchType === 'option7') {    // неудаленные
                axios
                    .get(config.getSearchRoute('deleted', 0,'null'))
                    .then(response => (this.products = response.data.data));
            }
            if (this.searchType === 'option8') {    // удаленные
                axios
                    .get(config.getSearchRoute('deleted', 1,'null'))
                    .then(response => (this.products = response.data.data));
            }
        }
    },
    mounted() {
        this.getProducts()
    }
}
</script>

<style scoped>

.price-position {
    width: 100px;
    margin-left: 15px;
}

.buttonPosition {
    margin-top: 16px;
}

</style>
