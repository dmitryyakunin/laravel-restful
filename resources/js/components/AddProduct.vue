<template>
    <div>
        <div class="card" style="width: 30rem;">
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="inputName">Наименование</label>
                        <input type="text" class="form-control" id="inputName" v-model="name"
                               placeholder="Наименование">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Описание</label>
                        <textarea class="form-control" rows="5" v-model="description" id="inputDescription"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputPrice">Цена</label>
                        <input type="text" class="form-control" id="inputPrice" v-model="price"
                               placeholder="Наименование">
                    </div>
                    <div> Категории </div>
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
                    <button class="btn btn-outline-primary" v-if="edit==='0'" v-on:click="addEditItem()">
                        Добавить товар
                    </button>
                    <button class="btn btn-outline-primary" v-if="edit==='1'" v-on:click="addEditItem()">
                        Сохранить изменения
                    </button>
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
        selectedCat: [],
        products: null,
    }),
    methods: {
        getCategories() {
            axios
                .get('http://laravel-restful/api/categories/')
                .then(response => (this.categories = response.data.data));
        },
        closeModal() {
            document.getElementById('close-btn').click();
        },
        addEditItem() {
            if(this.$route.params.edit === '1') {   // редактирование

                for (let i=0; i < this.selected.length; i++) {
                    let category = this.selected[i].split('-')
                    for (let k=0; k < this.categories.length; k++) {
                        if (category[1] === this.categories[k].name ) {
                            this.selectedCat[i] = this.categories[k].id
                        }
                    }
                }
                const payload = {
                    name: this.name,
                    description: this.description,
                    price: this.price,
                    categories: this.selectedCat
                };

                axios.put("http://laravel-restful/api/products/"+this.id, payload)
                    .then(response => {
                        this.id = response.data.data.id
                    }).catch(error => console.log(error));
            } else {
                axios.post("http://laravel-restful/api/products", payload)
                    .then(response => {
                        this.id = response.data.data.id
                    }).catch(error => console.log(error));
            }
            this.getProducts()
            this.$router.push({name: 'products'}).catch(err => { })
        },
        getProducts() {
            axios
                .get('http://laravel-restful/api/products/')
                .then(response => (this.products = response.data.data));
        },
    },
    mounted() {
        if(this.$route.params.edit === '1') {  // редактирование
            this.edit = this.$route.params.edit
            this.id = this.$route.params.id
            this.name = this.$route.params.name
            this.price = this.$route.params.price
            this.description = this.$route.params.description

            if (this.$route.params.selected === undefined) { // нет категорий
                this.selected = []
            } else {
                for (let i=0; i < this.$route.params.selected.length; i++) {
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
