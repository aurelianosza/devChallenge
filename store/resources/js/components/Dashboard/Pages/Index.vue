<template>
    <div class="container">
        <div class="row mt-4">
            <div class="col col-4">
                <div class="card">
                    <div class="card-body bg-primary text-white">
                        <h5 class="card-title">Products</h5>
                        <vue-fontawesome
                            icon="list"
                            color="#fff"
                            size="8"
                        ></vue-fontawesome>
                        <p class="card-text">
                            See here the products in your store.
                        </p>
                        <router-link :to="{ name: 'products' }">
                            <button class="btn btn-default">View</button>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col col-4">
                <div class="card">
                    <div class="card-body bg-success text-white">
                        <h5 class="card-title">Load Products</h5>
                        <vue-fontawesome
                            icon="upload"
                            color="#fff"
                            size="8"
                        ></vue-fontawesome>
                        <p class="card-text">
                            Upload a CVS formated file to load products.
                        </p>
                        <router-link :to="{ name: 'load-products' }">
                            <button class="btn btn-default">View</button>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "index"
};
</script>

<style scoped>
.card {
    width: 100%;
    height: 150px;
    overflow: hidden;
}
i {
    position: absolute;
    opacity: 0.2;
    top: -8%;
    right: -5%;
    transform: rotate(10deg);
}
.btn-default {
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
    font-weight: 600;
}
</style>
