<template>
    <div>
        <div class="card" style="width: 600px;">
            <div class="card-body">
                <form id="add-product">
                    <div class="form-group">
                        <label for="inputName">Наименование</label>
                        <input type="text" class="form-control" id="inputName" v-model="name"
                               placeholder="Наименование" required>
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Описание</label>
                        <textarea class="form-control" rows="5" v-model="description" id="inputDescription"
                                  required>
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputPrice">Цена</label>
                        <input type="text" class="form-control" id="inputPrice" v-model="price"
                               placeholder="Цена">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" v-model="published" id="checkPublished">
                        <label class="form-check-label" for="checkPublished">
                            Опубликовано
                        </label>
                    </div>
                    <div> Категории</div>
                    <table class="table table-bordered">
                        <tr v-for="(item, index ) in selected" :key="index">
                            <td> {{ item }}</td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                            data-target="#exampleModal">
                        Добавить/изменить категории
                    </button>

                    <p></p>
                    <div class="row justify-content-between" style="padding-right: 20px">
                        <div class="col-sm-5">
                            <button class="btn btn-outline-primary" v-if="edit==='0'"
                                    v-on:click="addEditItem()">
                                Добавить товар
                            </button>
                            <button class="btn btn-outline-primary" v-if="edit==='1'"
                                    v-on:click="addEditItem()">
                                Сохранить изменения
                            </button>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-outline-primary" v-on:click="returnToList()">Отмена</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Список категорий</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-btn">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="multiSelect">Выберите категории товара</label>
                            <select multiple class="form-control" v-model="selected" id="multiSelect">
                                <option v-for="item in categories" :key="item.id">
                                    {{ item.id }}-{{ item.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            Закрыть
                        </button>
                        <button type="button" class="btn btn-outline-primary" v-on:click="closeModal()">
                            Сохранить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import config from "../helpers/config";

export default {
    name: "AddProduct",
    data: () => ({
        edit: '0',
        id: null,
        name: null,
        price: null,
        description: null,
        selected: [],
        categories: null,
        published: true,
        selectedCat: [],
        products: null,
        payload: null,
    }),
    methods: {
        checkForm: function () {
            return (this.name && this.description)
        },
        getCategories() {
            axios
                .get(config.endpoint + '/categories/')
                .then(response => (this.categories = response.data.data));
        },
        closeModal() {
            document.getElementById('close-btn').click();
        },
        addEditItem() {
            if (!this.checkForm()) {
                return
            }

            if (this.$route.params.edit === '1') {   // редактирование
                this.getPayload()

                axios.put("http://laravel-restful/api/products/" + this.id, this.payload)
                    .then(response => {
                        this.id = response.data.data.id
                        this.$router.push({name: 'products'}).catch(err => {
                        })
                    }).catch(error => console.log(error));
            } else {
                this.getPayload()
                this.payload.categories = []

                axios.post(config.endpoint + '/products', this.payload) // сохраним
                    .then(response => {
                        this.id = response.data.data.id

                        this.payload.categories = this.selectedCat  // восстановим категории
                        axios.put(config.endpoint + '/products/' + this.id, this.payload) // запишем категории
                            .then(response => {
                                this.id = response.data.data.id
                                this.$router.push({name: 'products'}).catch(err => {
                                })
                            }).catch(error => console.log(error));

                    }).catch(error => console.log(error));
            }

        },
        getPayload() {
            for (let i = 0; i < this.selected.length; i++) {
                let category = this.selected[i].split('-')
                for (let k = 0; k < this.categories.length; k++) {
                    if (category[1] === this.categories[k].name) {
                        this.selectedCat[i] = this.categories[k].id
                    }
                }
            }
            let published = this.published ? 1 : 0
            this.payload = {
                name: this.name,
                description: this.description,
                price: this.price,
                categories: this.selectedCat,
                published: published
            }
        },
        getProducts() {
            axios
                .get(config.endpoint + '/products/')
                .then(response => (this.products = response.data.data));
        },
        returnToList() {
            this.$router.push({name: 'products'})
                .catch(error => {
                    console.log(error)
                })
        },
    },
    mounted() {
        this.edit = this.$route.params.edit

        if (this.$route.params.edit === '1') {  // редактирование
            this.id = this.$route.params.id
            this.name = this.$route.params.name
            this.price = this.$route.params.price
            this.description = this.$route.params.description
            this.published = (this.$route.params.published === 1);

            if (this.$route.params.selected === undefined) { // нет категорий
                this.selected = []
            } else {
                for (let i = 0; i < this.$route.params.selected.length; i++) {
                    this.selected[i] = this.$route.params.selected[i].id +
                        '-' + this.$route.params.selected[i].name
                }
            }

        }
        this.getCategories()
    }
}
</script>

<style scoped>

</style>
