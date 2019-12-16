<template>
    <div class="col col-12 mt-4">
        <div class="card">
            <div class="card-header">Product</div>
            <div class="card-body">
                <validation-observer v-slot="{ handleSubmit }">
                    <form @submit.prevent="handleSubmit(save)">
                        <div class="row">
                            <div class="col col-12">
                                <div class="row">
                                    <div class="col col-12">
                                        <div class="form-group">
                                            <ValidationProvider
                                                name="name"
                                                rules="required|max:64|min:2"
                                                v-slot="{ errors, valid }"
                                            >
                                                <label for="name">Name</label>
                                                <input
                                                    type="text"
                                                    name="name"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.length != 0,
                                                        'is-valid':
                                                            name &&
                                                            errors.length == 0
                                                    }"
                                                    v-model="name"
                                                    placeholder="Product Name"
                                                />
                                                <small
                                                    class="form-text text-danger"
                                                >
                                                    {{ errors[0] }}
                                                </small>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-12">
                                        <div class="form-group">
                                            <validation-provider
                                                name="description"
                                                rules="max:255"
                                                v-slot="{ errors }"
                                            >
                                                <label for="descirption"
                                                    >Description</label
                                                >
                                                <textarea
                                                    name="description"
                                                    id="description"
                                                    cols="30"
                                                    rows="4"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.length != 0,
                                                        'is-valid':
                                                            description &&
                                                            errors.length == 0
                                                    }"
                                                    v-model="description"
                                                ></textarea>
                                                <small
                                                    class="form-text text-danger"
                                                    >{{ errors[0] }}</small
                                                >
                                            </validation-provider>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <validation-provider
                                            name="category"
                                            rules="required|min_value:1"
                                            v-slot="{ errors }"
                                        >
                                            <div class="form-group">
                                                <label for>Category</label>
                                                <my-select
                                                    url="categories"
                                                    select="id"
                                                    label="label"
                                                    v-model="category_id"
                                                    class="is-valid"
                                                ></my-select>
                                                <small
                                                    class="form-text text-danger"
                                                    >{{ errors[0] }}</small
                                                >
                                            </div>
                                        </validation-provider>
                                        <div class="form-gorup">
                                            <validation-provider
                                                name="price"
                                                rules="required|min_value:0.99"
                                                v-slot="{ errors }"
                                            >
                                                <label for="price">Price</label>
                                                <div class="input-group">
                                                    <div
                                                        class="input-group-prepend"
                                                    >
                                                        <span
                                                            class="input-group-text"
                                                            >$</span
                                                        >
                                                    </div>
                                                    <input
                                                        type="text"
                                                        name="price"
                                                        v-mask="[
                                                            '.##',
                                                            '#.##',
                                                            '##.##',
                                                            '###.##',
                                                            '####.##',
                                                            '#####.##'
                                                        ]"
                                                        masked="false"
                                                        v-model="price"
                                                        class="form-control"
                                                        :class="{
                                                            'is-invalid':
                                                                errors.length !=
                                                                0,
                                                            'is-valid':
                                                                price &&
                                                                errors.length ==
                                                                    0
                                                        }"
                                                    />
                                                </div>
                                                <small
                                                    class="form-text text-danger"
                                                    >{{ errors[0] }}</small
                                                >
                                            </validation-provider>
                                        </div>
                                    </div>
                                    <div class="col col-3">
                                        <label
                                            class="container-img"
                                            for="customFile"
                                        >
                                            <img
                                                :src="
                                                    `http://localhost:8000/storage/${image}`
                                                "
                                            />
                                            <div class="img-mask">
                                                Choose the image
                                            </div>
                                        </label>

                                        <input
                                            type="file"
                                            class="custom-file-input"
                                            id="customFile"
                                            ref="file"
                                            name="image"
                                            @change="onChangeFileUpload"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12">
                                <input
                                    type="submit"
                                    :value="
                                        `${id == 0 ? 'Add' : 'Save'} Product`
                                    "
                                    class="btn btn-primary float-right"
                                />
                            </div>
                        </div>
                    </form>
                </validation-observer>
            </div>
        </div>
    </div>
</template>

<script>
import MySelect from "../../Includes/MySelect";
import { ValidationProvider, extend, ValidationObserver } from "vee-validate";
import * as rules from "vee-validate/dist/rules";
import FormData from "form-data";

import { mask } from "vue-the-mask";

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

export default {
    name: "product",
    data() {
        return {
            id: 0,
            name: "",
            category_id: 0,
            description: "",
            price: "00",
            image: null,
            changeImage: false
        };
    },
    methods: {
        save() {
            this.$http({
                method: this.id != 0 ? "put" : "post",
                url: `/products${this.id != 0 ? "/" + this.id : ""}`,
                data: {
                    name: this.name,
                    category_id: this.category_id,
                    description: this.description,
                    price: this.price
                }
            })
                .then(res => {
                    if (this.id == 0) this.id = res.data.data.product.id;
                    this.uploadImage().then(res => {
                        this.$toast(
                            "success",
                            `${this.id == 0 ? "Created" : "Saved"}`
                        );
                        this.$router.push("/dashboard/products");
                    });
                })
                .catch();
        },
        loadModel() {
            this.id = this.$route.params.id ? this.$route.params.id : 0;
            this.$http({
                url: `products/${this.id}`,
                method: "get"
            }).then(res => {
                const data = res.data.data.product;
                this.name = data.name;
                this.description = data.description;
                this.price = data.price;
                this.category_id = data.category.id;
                this.image = data.image;
            });
        },
        onChangeFileUpload() {
            this.file = this.$refs.file.files[0];
            this.changeImage = true;
        },
        uploadImage() {
            return new Promise((resolve, reject) => {
                if (!this.changeImage) {
                    resolve();
                } else {
                    let formData = new FormData();
                    formData.append("image", this.file);

                    this.$http(
                        {
                            method: "post",
                            url: `/products/${this.id}/image`,
                            data: formData
                        },
                        {
                            headers: {
                                "Content-Type": "multipart/form-data"
                            }
                        }
                    )
                        .then(res => {
                            resolve();
                        })
                        .catch(err => {
                            reject(err);
                        });
                }
            });
        }
    },
    components: {
        MySelect,
        ValidationProvider,
        ValidationObserver
    },
    directives: { mask },
    mounted() {
        this.loadModel();
    }
};
</script>

<style scoped>
.container-img {
    width: 150px;
    height: 150px;
    position: relative;
    margin: 0 auto;
    overflow: hidden;
}
.container-img img {
    object-fit: cover;
    height: 100%;
    width: 100%;
    cursor: pointer;
}
.img-mask {
    background-color: red;
}
</style>
