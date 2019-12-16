<template>
    <div class="table-responsive">
        <input type="text" class="mb-2" v-model="query" />
        <router-link :to="{ name: `add-${url}` }" class="float-right">
            <vue-fontawesome icon="plus" size="1"></vue-fontawesome>Add
        </router-link>
        <table class="table table-striped mb-4">
            <thead>
                <th scope="col" v-for="(field, idx) in fields" :key="idx">
                    {{ field }}
                </th>
                <th>Settings</th>
            </thead>
            <tbody v-if="models.length != 0">
                <tr v-for="(model, idx) in models" :key="idx">
                    <td v-for="(field, idy) in fields" :key="idy">
                        <div v-if="field in formater">
                            {{ formater[field](model[field]) }}
                        </div>
                        <div v-else-if="field in components">
                            <component :is="components[field](model[field])" />
                        </div>
                        <div v-else>
                            {{ model[field] }}
                        </div>
                    </td>
                    <td>
                        <div class="btn-group">
                            <router-link
                                :to="{
                                    name: `edit-${url}`,
                                    params: { id: model.id }
                                }"
                            >
                                <button type="button" class="btn btn-primary">
                                    <a href>
                                        <vue-fontawesome
                                            icon="gear"
                                            color="#fff"
                                            size="1.2"
                                        ></vue-fontawesome>
                                    </a>
                                </button>
                            </router-link>

                            <button
                                type="button"
                                class="btn btn-danger"
                                @click="deleteModel(model.id, idx)"
                            >
                                <vue-fontawesome
                                    icon="trash"
                                    color="#fff"
                                    size="1.2"
                                ></vue-fontawesome>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="length > 10">
            <nav class="float-right">
                <ul class="pagination">
                    <li class="pagination-item">
                        <a
                            href
                            @click.prevent="() => (page -= page != 1 ? 1 : 0)"
                            class="page-link"
                            >Previous</a
                        >
                    </li>
                    <li
                        v-for="(numberPage, idx) in Array.from(
                            Array(Math.ceil(length / 10)).keys()
                        )"
                        :key="idx"
                        class="pagination-item"
                    >
                        <a
                            href
                            @click.prevent="() => (page = numberPage + 1)"
                            class="page-link"
                            :class="{
                                'bg-primary text-white': numberPage + 1 == page
                            }"
                            >{{ numberPage + 1 }}</a
                        >
                    </li>
                    <li class="pagination-item">
                        <a
                            href
                            @click.prevent="
                                () =>
                                    (page +=
                                        page != Math.ceil(length / 10) ? 1 : 0)
                            "
                            class="page-link"
                            >Next</a
                        >
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    name: "my-table",
    props: {
        fields: Array,
        url: String,
        formater: Object,
        components: Object
    },
    data() {
        return {
            models: [],
            length: 0,
            page: 1,
            query: ""
        };
    },
    watch: {
        query() {
            this.page = 1;
            this.loadModels();
        },
        page: "loadModels"
    },
    methods: {
        loadModels() {
            this.$http({
                url: `${this.url}?query=${this.query}&page=${this.page}`,
                method: "get"
            }).then(res => {
                this.models = res.data.data[this.url];
                this.length = res.data.data.length;
            });
        },
        deleteModel(id) {
            this.$askDelete()
                .then(() => {
                    this.$http({
                        method: "delete",
                        url: `${this.url}/${id}`
                    }).then(res => {
                        this.$toast("success", "Deleted");
                        this.loadModels();
                    });
                })
                .catch(() => {
                    this.$toast("error", "Canceled");
                });
        }
    },
    created() {
        this.loadModels();
    }
};
</script>
<style scoped>
td {
    vertical-align: middle;
}
</style>
