<template>
    <div>
        <div class="card" style="width: 600px;">
            <div class="card-body">
                <form id="add-category">
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
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" v-model="published" id="checkPublished">
                        <label class="form-check-label" for="checkPublished">
                            Опубликовано
                        </label>
                    </div>

                    <p></p>
                    <div class="row justify-content-between" style="padding-right: 20px">
                        <div class="col-sm-5">
                            <button class="btn btn-outline-primary" v-if="edit==='0'"
                                    v-on:click="addEditItem()">
                                Добавить категорию
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
    </div>

</template>

<script>
import config from "../helpers/config";

export default {
    name: "AddCategory",
    data: () => ({
        edit: '0',
        id: null,
        name: null,
        description: null,
        published: true,
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

            if(this.$route.params.edit === '1') {   // редактирование
                this.getPayload()

                axios.put(config.endpoint + '/categories/'+this.id, this.payload)
                    .then(response => {
                        this.id = response.data.data.id
                        this.$router.push({name: 'categories'}).catch(err => { })
                    }).catch(error => console.log(error));
            } else {                                // добавление
                this.getPayload()

                axios.post(config.endpoint + '/categories', this.payload)
                    .then(response => {
                        this.id = response.data.data.id
                        this.$router.push({name: 'categories'}).catch(err => { })
                    }).catch(error => console.log(error));
            }
        },
        getPayload() {
            let published = this.published ? 1 : 0
            this.payload = {
                name: this.name,
                description: this.description,
                published: published
            }
        },
        returnToList() {
            this.$router.push({name: 'categories'})
                .catch(error => {
                    console.log(error)
                })
        },
    },
    mounted() {
        this.edit = this.$route.params.edit

        if(this.$route.params.edit === '1') {  // редактирование
            this.id = this.$route.params.id
            this.name = this.$route.params.name
            this.description = this.$route.params.description
            this.published = (this.$route.params.published === 1);
        }
    }
}
</script>

<style scoped>

</style>
