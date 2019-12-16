<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <div class="row">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "../components/Includes/Navbar";
export default {
    name: "basic-template",
    components: {
        Navbar
    }
};
</script>
