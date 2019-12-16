<template>
    <div>
        <basic-template>
            <div class="container">
                <div class="row">
                    <div class="col col-12">
                        <div class="card mt-4">
                            <div
                                v-infinite-scroll="handleScroll"
                                infinite-scroll-distance="0"
                                infinite-scroll-disabled="busy"
                                class="card-body"
                            >
                                <div class="container-fluid">
                                    <div class="row no-gutters">
                                        <div
                                            class="col col-xl-2 col-lg-3 col-md-4 col-6"
                                            v-for="(product, idx) in products"
                                            :key="idx"
                                        >
                                            <div
                                                class="card no-border mb-4 mt-4"
                                            >
                                                <div
                                                    class="container-image"
                                                    aria-label=" dkjfdsjf"
                                                >
                                                    <img
                                                        v-if="product.image"
                                                        :src="
                                                            `http://localhost:8000/storage/${product.image}`
                                                        "
                                                    />
                                                    <img
                                                        v-else
                                                        src="https://www.unhooked.be/wp-content/uploads/sites/9/2018/08/no-image.png"
                                                    />
                                                </div>
                                                <div class="card-body">
                                                    <div class="container-name">
                                                        <div class="name">
                                                            {{ product.name }}
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="container-description"
                                                    >
                                                        <div
                                                            class="description"
                                                        >
                                                            {{
                                                                product.description
                                                            }}
                                                        </div>
                                                    </div>
                                                    <div class="price">
                                                        <span class="big dollar"
                                                            >$</span
                                                        >
                                                        <span class="big">{{
                                                            product.price.split(
                                                                "."
                                                            )[0]
                                                        }}</span>
                                                        <span class="small">{{
                                                            "." +
                                                                product.price.split(
                                                                    "."
                                                                )[1]
                                                        }}</span>
                                                    </div>
                                                    <button
                                                        class="btn btn-outline-primary btn-block"
                                                    >
                                                        See item
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="busy" class="spinner-border spinner">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </basic-template>
    </div>
</template>

<script>
import BasicTemplate from "../templates/BasicTamplate";
import infiniteScroll from "vue-infinite-scroll";

export default {
    name: "home",
    data() {
        return {
            products: [],
            busy: false
        };
    },
    components: {
        BasicTemplate
    },
    methods: {
        load() {
            this.$http({
                method: "get",
                url: "products/random"
            }).then(res => {
                this.products = [...this.products, ...res.data.data.products];
                this.busy = false;
            });
        },
        handleScroll() {
            this.busy = true;
            setTimeout(this.load, 3000);
        }
    },
    directives: { infiniteScroll },
    created() {
        this.load();
    }
};
</script>

<style scoped>
.container-image {
    width: 100%;
    padding-top: 80%;
    position: relative;
}
.container-image img {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    object-fit: contain;
    height: 100%;
    width: 100%;
}
.container-name {
    overflow: hidden;
    position: relative;
    width: 100%;
    padding-top: 30%;
    font-weight: 400;
}
.name {
    position: absolute;
    top: 0;
    color: #444;
    font-size: 20px;
}
.container-description {
    width: 100%;
    padding-top: 50%;
    position: relative;
    overflow: hidden;
}
.description {
    color: #888;
    font-size: 14px;
    position: absolute;
    text-align: justify;
    top: 0;
}
.price {
    color: #888;
    font-family: sans-serif;
}
.price .big {
    overflow: hidden;
    font-size: 20px;
    font-weight: 400;
}
.price .dollar {
    font-weight: 300;
}
.small {
    font-size: 12px;
}
.spinner {
    position: relative;
    display: block;
    margin: 40px auto;
    height: 50px;
    width: 50px;
    color: #ccc;
}
.no-border {
    border: none;
    border-radius: 0;
    border-right: #eee solid 1px;
    border-left: #eee solid 1px;
}
</style>
