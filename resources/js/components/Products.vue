<template xmlns="http://www.w3.org/1999/html">
    <div>
        <h4> Товары </h4>
        <button class="btn btn-outline-primary position" v-on:click="addItem()">
            Добавить товар
        </button>

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
                axios.put('http://laravel-restful/api/product-delete/' + id)
                    .then(response => {
                        console.log('deleted ' + id);
                        this.getProducts()
                    });
            }
        },
        addItem() {
            this.$router.push({ name: 'add-products', params: { edit: '0' }}).catch(err => { })
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
