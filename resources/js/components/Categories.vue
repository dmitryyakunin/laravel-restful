<template>
    <div>
        <h3>Категории</h3>

        <button class="btn btn-outline-primary position" v-on:click="addItem()">
            Добавить категорию
        </button>

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
                            v-on:click="editItem(item.id, item.name, item.description, item.published)">
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
    </div>
</template>

<script>
export default {
    name: "Categories",
    data: () => ({
        categories: null,
    }),
    methods: {
        getCategories() {
            axios
                .get('http://laravel-restful/api/categories/')
                .then(response => (this.categories = response.data.data))
                .catch(error => console.log(error));
        },
        addItem() {
            this.$router.push({
                name: 'add-category',
                params: {
                    edit: '0'
                }})
                .catch(error => {console.log(error)})
        },
        editItem(id, name, description, published) {
            this.$router.push({
                name: 'add-category',
                params: {
                    edit: '1',
                    id: id,
                    name: name,
                    description: description,
                    published: published
                }
            }).catch(error => {console.log(error)})
        },
        deleteItem(id) {
            if (confirm('Удалить категорию? ')) {
                // проверим товары в категории
                axios.get("http://laravel-restful/api/category-search-products/"+id)
                    .then(response => {
                        //console.log(response.data)
                        if(response.data === 0) {
                            // удалим программно
                            axios.put('http://laravel-restful/api/category-delete/' + id)
                                .then(response => {
                                    console.log('deleted ' + id);
                                    this.getCategories()
                                }).catch(error => console.log(error));
                        } else {
                            alert('В категории есть товары - не удаляем!')
                        }
                    }).catch(error => console.log(error));
            }
        },
    },
    mounted() {
        this.getCategories()
    }
}
</script>

<style scoped>

</style>
