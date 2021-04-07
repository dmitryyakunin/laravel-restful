<template>
    <div>
        <h3>Категории</h3>

        <div class="row justify-content-between">
            <div class="col-md-4">
                <button class="btn btn-outline-primary position" v-on:click="addItem()">
                    Добавить категорию
                </button>
            </div>
            <div class="col-md-2" v-if="allItems === 0">
                <button class="btn btn-outline-primary position" v-on:click="getCategories()">
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
            <tr>
                <th> ID</th>
                <th> Наименование</th>
                <th> Описание</th>
                <th colspan="2"> Действие</th>
                <th> Удал.</th>
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
                <td>
                    {{ item.deleted }}
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import config from "../helpers/config";

export default {
    name: "Categories",
    data: () => ({
        categories: null,
        allItems: 1,
    }),
    methods: {
        getCategories() {
            this.allItems = 1
            axios
                .get(config.endpoint + '/categories/')
                .then(response => (this.categories = response.data.data))
                .catch(error => console.log(error));
        },
        notDeleted() {
            this.allItems = 0
            axios
                .get(config.endpoint + '/categories/search/deleted/0')
                .then(response => (this.categories = response.data.data));
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
                axios.get(config.endpoint + '/categories/search/products/'+id)
                    .then(response => {
                        //console.log(response.data)
                        if(response.data === 0) {
                            // удалим программно
                            axios.delete(config.endpoint + '/categories/' + id)
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
