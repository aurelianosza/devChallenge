<template>
    <div class="col col-12 mt-4">
        <div class="card">
            <div class="card-header">Products</div>
            <div class="card-body">
                <my-table
                    :fields="[
                        'name',
                        'description',
                        'price',
                        'category',
                        'image'
                    ]"
                    :url="'products'"
                    :formater="{
                        price: formatMoney,
                        category: formatCategory
                    }"
                    :components="{
                        image: componentImage
                    }"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import MyTable from "../../Includes/MyTable";
import currencyFormatter from "currency-formatter";

export default {
    name: "products",
    components: {
        MyTable
    },
    methods: {
        formatMoney(value) {
            return currencyFormatter.format(value, { code: "USD" });
        },
        formatCategory(value) {
            return value.name;
        },
        componentImage(value) {
            return {
                data() {
                    return {
                        value: value,
                        style: {
                            root: {
                                width: "80px",
                                height: "80px",
                                overflow: "hidden"
                            },
                            image: {
                                objectFit: "cover",
                                width: "100%",
                                height: "100%"
                            }
                        }
                    };
                },
                template: `<div :style="style.root">
                                <img v-if="value" :src="\`http://localhost:8000/storage/\${value}\`" :style="style.image"/>
                                <img v-else src="https://www.unhooked.be/wp-content/uploads/sites/9/2018/08/no-image.png" :style="style.image"/>
                            </div>`
            };
        }
    }
};
</script>
