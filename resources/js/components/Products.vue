<template xmlns="http://www.w3.org/1999/html">
    <div>
        <h4> Товары </h4>
        <div class="row justify-content-between">
            <div class="col-md-4">
                <button class="btn btn-outline-primary position" v-on:click="addItem()">
                    Добавить товар
                </button>
            </div>
            <div class="col-md-2" v-if="allItems === 0">
                <button class="btn btn-outline-primary position" v-on:click="getProducts()">
                    Все элементы
                </button>
            </div>
            <div class="col-md-2" v-if="allItems === 1">
                <button class="btn btn-outline-primary position" v-on:click="notDeleted()">
                    Неудаленные
                </button>
            </div>
        </div>

        <table class="table table-bordered">
            <tr class="table-active">
                <th> Наименование</th>
                <th> Описание</th>
                <th> Цена</th>
                <th colspan="2"> Действие</th>
                <th> Удал.</th>
            </tr>
            <tr v-for="item in products" :key="item.id">
                <td> {{ item.name }}</td>
                <td> {{ item.description }}</td>
                <td> {{ item.price }}</td>
                <td>
                    <button class="btn btn-outline-success"
                            v-on:click="editItem(
                                item.id,
                                item.name,
                                item.price,
                                item.description,
                                item.categories,
                                item.published)">
                        Редактировать
                    </button>
                </td>
                <td>
                    <button class="btn btn-outline-danger" v-on:click="deleteItem(item.id)">
                        Удалить
                    </button>
                </td>
                <td>
                    {{ item.deleted }}
                </td>
            </tr>
        </table>
        <br/>

    </div>
</template>

<script>
import config from '../helpers/config'

export default {
    name: "Products",
    data: () => ({
        products: null,
        allItems: 1,
    }),
    methods: {
        getProducts() {
            this.allItems = 1
            axios
                .get(config.endpoint + '/products/')
                .then(response => (this.products = response.data.data))
                .catch(error => console.log(error));
        },
        notDeleted() {
            this.allItems = 0
            axios
                .get(config.endpoint + '/products/deleted/0' + '/null')
                .then(response => (this.products = response.data.data));
        },
        deleteItem(id) {
            if (confirm('Удалить продукт? ')) {
                axios.delete(config.endpoint + '/products/' + id)
                    .then(response => {
                        console.log('deleted ' + id);
                        this.getProducts()
                    }).catch(error => console.log(error));
            }
        },
        addItem() {
            this.$router.push({name: 'add-products', params: {edit: '0'}}).catch(err => {
            })
        },
        editItem(id, name, price, description, selected, published) {
            this.$router.push({
                name: 'add-products',
                params: {
                    edit: '1',
                    id: id,
                    name: name,
                    price: price,
                    description: description,
                    selected: selected,
                    published: published
                }
            }).catch(err => {
            })
        }
    },
    mounted() {
        this.getProducts()
    }
}
</script>

<style scoped>

</style>
