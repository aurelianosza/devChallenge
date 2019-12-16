<template>
    <basic-template>
        <router-view></router-view>
    </basic-template>
</template>

<script>
import BasicTemplate from "../../templates/BasicTamplate";

export default {
    name: "dashboard",
    components: {
        BasicTemplate
    },
    data() {
        return {};
    }
};
</script>
