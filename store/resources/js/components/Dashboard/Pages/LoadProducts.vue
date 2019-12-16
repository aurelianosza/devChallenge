<template>
    <div class="col col-12 mt-4">
        <div class="card">
            <div class="card-header">
                Load Products
            </div>
            <div class="card-body">
                <form @submit.prevent="uploadFile">
                    <div class="form-group">
                        <div class="custom-file">
                            <input
                                type="file"
                                class="custom-file-input form-control"
                                id="customFile"
                                ref="file"
                                @change="onChangeFIleUpload"
                            />
                            <label class="custom-file-label" for="customFile"
                                >Choose file</label
                            >
                        </div>
                    </div>
                    <input
                        type="submit"
                        value="Load file"
                        class="btn btn-block btn-info"
                    />
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "loadProducts",
    data() {
        return {
            file: null,
            changeFile: false
        };
    },
    methods: {
        onChangeFIleUpload() {
            this.file = this.$refs.file.files[0];
            this.changeFile = true;
        },
        uploadFile() {
            if (!this.changeFile) {
                this.$toast("error", "Select a File.");
                return;
            }
            let formData = new FormData();
            formData.append("file", this.file);

            this.$http(
                {
                    method: "post",
                    url: "products/load",
                    data: formData
                },
                {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                }
            ).then(res => {
                this.$toast("success", "File uploaded");
                this.$router.push("/dashboard");
            });
        }
    }
};
</script>
