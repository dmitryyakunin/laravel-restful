<template>
    <div>
        <h4> Товары </h4>
        <router-link class="btn btn-outline-primary position" to="/add-products" tag="button">Добавить товар
        </router-link>
        <table class="table table-bordered">
            <tr class="table-active">
                <th> Наименование</th>
                <th> Описание</th>
                <th> Цена</th>
                <th colspan="2"> Действие</th>
            </tr>
            <tr v-for="item in products" :key="item.id">
                <td> {{ item.name }}</td>
                <td> {{ item.description }}</td>
                <td> {{ item.price }}</td>
                <td>
                    <button class="btn btn-outline-success"
                            v-on:click="editItem(item.id, item.name, item.price, item.description, item.categories)">
                        Редактировать
                    </button>
                </td>
                <td>
                    <button class="btn btn-outline-danger" v-on:click="deleteItem(item.id)">
                        Удалить
                    </button>
                </td>
            </tr>
        </table>
        <br/>

    </div>
</template>

<script>
export default {
    name: "Products",
    data: () => ({
        products: null,
    }),
    methods: {
        getProducts() {
            axios
                .get('http://laravel-restful/api/products/')
                .then(response => (this.products = response.data.data));
        },
        deleteItem(id) {
            if (confirm('Удалить продукт? ')) {
                axios.delete('http://laravel-restful/api/products/' + id)
                    .then(response => {
                        this.getProducts()
                        console.log('deleted ' + id);
                    });
            }
        },
        editItem(id, name, price, description, selected) {
            this.$router.push({
                name: 'add-products',
                params: {
                    edit: '1',
                    id: id,
                    name: name,
                    price: price,
                    description: description,
                    selected: selected
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
.position {
    margin-top: 10px;
    margin-bottom: 5px;
}
</style>
