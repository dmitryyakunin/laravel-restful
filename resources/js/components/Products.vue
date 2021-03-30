<template>
    <div>
        <h3> Товыры </h3>
        <table>
            <tr>
                <th> Наименование </th>
                <th> Описание </th>
                <th> Действие </th>
            </tr>
            <tr v-for="item in products" :key="item.id">
                <td> {{ item.name }}</td>
                <td> {{ item.description }}</td>
                <td> <button v-on:click="deleteItem(item.id)"> Удалить </button></td>
            </tr>
        </table>
        <br/>
        <form>
            <input type="text" v-model="name" placeholder="name" />  <br/>
            <textarea rows="10" cols="45" v-model="description" ></textarea> <br/>
            <input type="text" v-model="price" placeholder="price" /> <br/>
            <button v-on:click="addItem()">
                Добавить
            </button>
        </form>
    </div>
</template>

<script>
export default {
    name: "Products",
    data: () => ({
        products: null,
        id: null,
        name: null,
        price: null,
        description: null,
    }),
    methods: {
        getProducts() {
            axios
                .get('http://laravel-restful/api/products/')
                .then(response => (this.products = response.data.data));
        },
        addItem() {
            const payload = { name: this.name, description: this.description, price: this.price };
            axios.post("http://laravel-restful/api/products", payload)
                .then(response => {
                    this.id = response.data.data.id
                    this.getProducts()
                });
        },
        deleteItem(id) {
            if (confirm('Удалить продукт? ')) {
                axios.delete('http://laravel-restful/api/products/' + id)
                    .then(response => {
                        this.getProducts()
                        console.log('deleted '+id);
                    });
            }
        }
    },
    mounted() {
        this.getProducts()
    }
}
</script>

<style scoped>

</style>
