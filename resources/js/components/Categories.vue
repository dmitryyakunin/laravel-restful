<template>
    <div>
        <h3>Категории</h3>
        <router-link class="btn btn-outline-primary position" to="/add-category" tag="button">
            Добавить категорию
        </router-link>

        <table class="table table-bordered">
            <tr>
                <th> ID</th>
                <th> Наименование</th>
                <th> Описание</th>
                <th colspan="2"> Действие</th>
            </tr>
            <tr v-for="item in categories" :key="item.id">
                <td> {{ item.id }}</td>
                <td> {{ item.name }}</td>
                <td> {{ item.description }}</td>
                <td>
                    <button class="btn btn-outline-success"
                            v-on:click="editItem(item.id, item.name, item.description, item.categories)">
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
        <form>
            <input type="text" v-model="name" placeholder="name"/> <br/>
            <input type="text" v-model="description" placeholder="description"/> <br/>
            <button v-on:click="addCategory()">
                Добавить
            </button>
        </form>
    </div>
</template>

<script>
export default {
    name: "Categories",
    data: () => ({
        categories: null,
        id: null,
        name: null,
        description: null,
    }),
    methods: {
        getCategories() {
            axios
                .get('http://laravel-restful/api/categories/')
                .then(response => (this.categories = response.data.data));
        },
        addCategory() {
            const payload = {name: this.name, description: this.description};
            axios.post("http://laravel-restful/api/categories", payload)
                .then(response => {
                    this.id = response.data.data.id
                    this.getCategories()
                });
        },
        editItem(id, name, price, description, selected) {
            this.$router.push({
                name: 'add-category',
                params: {
                    edit: '1',
                    id: id,
                    name: name,
                    description: description,
                    selected: selected
                }
            }).catch(err => {
            })
        },
        deleteItem(id) {
            if (confirm('Удалить категорию? ')) {
                axios.delete('http://laravel-restful/api/categories/' + id)
                    .then(response => {
                        this.getCategories()
                        console.log('deleted ' + id);
                    });
            }
        }
    },
    mounted() {
        this.getCategories()
    }
}
</script>

<style scoped>

</style>
