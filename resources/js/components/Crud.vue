<template>
    <div>
        <div
            class="container-fluid text-center bg-light position-sticky"
            style="top: 0"
        >
            <h2>User Management</h2>
        </div>
        <div class="container my-5">
            <div class="d-flex justify-content-between my-5">
                <input
                    type="search"
                    class="rounded border border-info text-center"
                    placeholder="search here..."
                    onKeyup="mysearch()"
                    name=""
                    id="search"
                    style="width: 70%"
                />

                <!-- Button trigger modal -->

                <button
                    type="button"
                    class="btn btn-outline-success"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    @click="addnewuser()"
                >
                    <i class="fas fa-user-plus"></i> Add
                </button>
            </div>

            <!-- Modal -->
            <div
                class="modal fade"
                id="exampleModal"
                data-bs-backdrop="static"
                data-bs-keyboard="false"
                tabindex="-1"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5
                                class="modal-title"
                                v-if="edit == false"
                                id="exampleModalLabel"
                            >
                                Create User
                            </h5>
                            <h5
                                class="modal-title"
                                v-if="edit == true"
                                id="exampleModalLabel"
                            >
                                Edit User
                            </h5>
                            <button
                                type="button"
                                id="close"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <form @submit.prevent="addUser">
                            <div class="modal-body">
                                <FormError
                                    v-if="errors"
                                    :err="errors"
                                ></FormError>
                                <div class="mb-3">
                                    <label for="username" class="form-label"
                                        >User Name</label
                                    >
                                    <input
                                        type="text"
                                        v-model="user.name"
                                        class="form-control"
                                        id="username"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label
                                        for="exampleInputEmail1"
                                        class="form-label"
                                        >Email</label
                                    >
                                    <input
                                        type="email"
                                        v-model="user.email"
                                        class="form-control"
                                        id="exampleInputEmail1"
                                        aria-describedby="emailHelp"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label"
                                        >Phone</label
                                    >
                                    <input
                                        type="number"
                                        v-model="user.mobile"
                                        class="form-control"
                                        id="phone"
                                        aria-describedby="emailHelp"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="country" class="form-label"
                                        >Country</label
                                    >
                                    <select
                                        class="form-select"
                                        v-model="user.country"
                                        id="country"
                                    >
                                        <option selected>Choose...</option>
                                        <option value="India">India</option>
                                        <option value="US">US</option>
                                        <option value="UK">UK</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="author" class="form-label"
                                        >Author</label
                                    >
                                    <select
                                        class="form-select"
                                        v-model="user.author"
                                        id="author"
                                    >
                                        <option selected>Choose...</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="mb-3 form-check">
                                    <input
                                        type="checkbox"
                                        v-model="user.status"
                                        class="form-check-input"
                                        id="exampleCheck1"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="exampleCheck1"
                                        >Status</label
                                    >
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="submit"
                                    v-if="edit == false"
                                    class="btn btn-success"
                                >
                                    Create
                                </button>
                                <button
                                    type="submit"
                                    v-if="edit == true"
                                    class="btn btn-success"
                                >
                                    Edit
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    data-bs-dismiss="modal"
                                >
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <Table @Edit="editUser($event)" @delete="deleteUser($event)" />
        </div>
    </div>
</template>
<script>
import Table from "./Table.vue";
import FormError from "./FormError.vue";

export default {
    components: { Table, FormError },

    data() {
        return {
            user: {
                name: "",
                email: "",
                mobile: "",
                country: "",
                author: 0,
                status: 0,
            },
            errors: null,

            edit: false,
            userId: "",
        };
    },

    methods: {
        //while editing the user,set the state
        editUser(id) {
            this.edit = true;

            this.userId = id;
            this.axios
                .get(`http://localhost:8000/api/users/${id}`)
                .then((res) => {
                    this.user = res.data;
                    this.edit = true;
                    this.errors = null;
                });
        },

        //for deleting the user
        deleteUser(id) {
            if (confirm("Are you sure delete this user?")) {
                this.axios
                    .delete(`http://localhost:8000/api/users/${id}`)
                    .then((res) => {
                        this.$emit("changeKey", Math.random());
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
        //on clicking add user button,the following states are reset.
        addnewuser() {
            this.edit = false;
            this.user.name = "";
            this.user.email = "";
            this.user.mobile = "";
            this.user.country = "";
            this.user.author = 0;
            this.user.status = 0;
            this.errors = null;
        },
        //on submitting the form
        addUser() {
            //for creating new user
            if (this.edit == false) {
                this.axios
                    .post("http://localhost:8000/api/users", this.user)
                    .then((response) => {
                        document.getElementById("close").click();
                        this.user.name = "";
                        this.user.email = "";
                        this.user.mobile = "";
                        this.user.country = "";
                        this.user.author = 0;
                        this.user.status = 0;

                        this.$emit("changeKey", Math.random());
                    })
                    .catch((err) => {
                        this.errors = err.response.data.errors;
                        console.log(err.response.data);
                    });
            }
            //for updating the existing user
            else {
                this.axios
                    .patch(
                        `http://localhost:8000/api/users/${this.userId}`,
                        this.user
                    )
                    .then((res) => {
                        document.getElementById("close").click();
                        this.user.name = "";
                        this.user.email = "";
                        this.user.mobile = "";
                        this.user.country = "";
                        this.user.author = 0;
                        this.user.status = 0;

                        this.$emit("changeKey", Math.random());
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
    },
};
</script>
<style scoped>
.btn:focus,
.btn:active:focus {
    box-shadow: none;
}
input[type="text"]:focus,
input[type="email"]:focus,
input[type="search"]:focus,
.form-select:focus,
input[type="number"]:focus {
    border-color: rgba(82, 168, 236, 0.8);
    outline: 0;
    outline: thin dotted \9;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}
</style>


