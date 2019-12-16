<template>
    <div>
        <v-select
            :options="options"
            @search="loadOptions"
            class="spinner"
            :reduce="option => option[select]"
            :label="label"
            placeholder="Select a brand"
            @input="changeValue"
            v-model="selected"
        />
    </div>
</template>

<script>
export default {
    name: "my-select",
    props: {
        url: String,
        select: String,
        label: String,
        value: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            options: [],
            selected: 0
        };
    },
    watch: {
        value() {
            this.loadOptions(this.value);
            this.selected = this.value;
        }
    },
    methods: {
        async loadOptions(search) {
            await this.$http({
                method: "get",
                url: `${this.url}?query=${search}`
            }).then(res => {
                this.options = [
                    ...this.options,
                    ...res.data.data[this.url].filter(
                        ele =>
                            !this.options.some(
                                already =>
                                    already[this.select] == ele[this.select]
                            )
                    )
                ];
            });
        },
        changeValue() {
            this.$emit("input", this.selected ? this.selected : 0);
        }
    },
    created() {
        this.loadOptions("");
    }
};
</script>
