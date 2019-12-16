<template>
    <div>
        <basic-template>
            <div class="col col-6 offset-3 mt-4">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <ValidationObserver v-slot="{ handleSubmit }">
                            <form @submit.prevent="handleSubmit(onSubmit)">
                                <div class="form-group">
                                    <ValidationProvider
                                        name="email"
                                        rules="required|email"
                                        v-slot="{ errors }"
                                    >
                                        <label for="email">Email</label>
                                        <input
                                            v-model="email"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.length,
                                                'is-valid':
                                                    errors.length == 0 && email
                                            }"
                                            placeholder="Your mail"
                                            name="email"
                                        />
                                        <small class="form-text text-muted">{{
                                            errors[0]
                                        }}</small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider
                                        name="password"
                                        rules="required|min:6"
                                        v-slot="{ errors }"
                                    >
                                        <label for="password">Password</label>
                                        <input
                                            v-model="password"
                                            type="password"
                                            name="password"
                                            placeholder="Your Password"
                                            :class="{
                                                'is-invalid': errors.length,
                                                'is-valid':
                                                    errors.length == 0 &&
                                                    password
                                            }"
                                            class="form-control"
                                        />
                                        <small class="form-text text-muted">{{
                                            errors[0]
                                        }}</small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <input
                                        type="submit"
                                        value="Login"
                                        class="btn btn-primary float-right"
                                    />
                                </div>
                            </form>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </basic-template>
    </div>
</template>

<script>
import { ValidationProvider, extend, ValidationObserver } from "vee-validate";
import * as rules from "vee-validate/dist/rules";

import BasicTemplate from "../../templates/BasicTamplate";

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

export default {
    name: "login",
    data() {
        return {
            email: "",
            password: ""
        };
    },
    components: {
        BasicTemplate,
        ValidationProvider,
        ValidationObserver
    },
    methods: {
        onSubmit() {
            console.log(this.$validator);

            this.$store
                .dispatch("login", {
                    email: this.email,
                    password: this.password
                })
                .then(() => {
                    this.$toast("success", "logged");
                    this.$router.push("/dashboard");
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>
